<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\SslCertificate\SslCertificate;
use App\Models\Domain;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function show($domain)
    {
        $url = $this->startsWithHttp($domain) ? $domain : 'https://' . $domain;

        try {
            $sslCertificate = SslCertificate::createForHostName($url);
            $headers = get_headers($url, 1);
            $headersJson = json_encode($headers);
            $phpVersion = isset($headers['X-Powered-By']) ? $headers['X-Powered-By'] : '0';

            DB::beginTransaction();

            $domainRecord = Domain::updateOrCreate(
                ['domain' => $domain],
                [
                    'ssl_issuer' => $sslCertificate->getIssuer(),
                    'ssl_expiration_date' => $sslCertificate->expirationDate(),
                    'ssl_is_valid' => $sslCertificate->isValid() ? 1 : 0,
                    'headers' => $headersJson,
                    'php_version' => $phpVersion,
                    'updated_at' => now()
                ]
            );

            DB::commit();

            $data = [
                'domain' => $domain,
                'issuer' => $domainRecord->ssl_issuer,
                'expirationDate' => $domainRecord->ssl_expiration_date,
                'isValid' => $domainRecord->ssl_is_valid,
                'headers' => $headers,
                'phpVersion' => $domainRecord->php_version,
            ];

        } catch (\Exception $e) {
            DB::rollback();
            $data = [
                'domain' => $domain,
                'error' => 'Failed to fetch SSL and header details. ' . $e->getMessage(),
            ];
        }

        return view('monitoring.show', compact('data'));
    }

    private function startsWithHttp($domain)
    {
        return preg_match('/^https?:\/\//', $domain);
    }
}