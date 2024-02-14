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
        try {
            $sslCertificate = SslCertificate::createForHostName($domain);
            DB::beginTransaction();
            $domainRecord = Domain::firstOrCreate(
                ['domain' => $domain],
                [
                    'ssl_issuer' => $sslCertificate->getIssuer(),
                    'ssl_expiration_date' => $sslCertificate->expirationDate(),
                    'SSL_is_valid' => $sslCertificate->isValid() ? 1 : 0,
                ]
            );
            if ($domainRecord->exists) {
                $domainRecord->ssl_issuer = $sslCertificate->getIssuer();
                $domainRecord->ssl_expiration_date = $sslCertificate->expirationDate();
                $domainRecord->SSL_is_valid = $sslCertificate->isValid() ? 1 : 0;
                $domainRecord->save();
            }
            DB::commit();
            $data = [
                'domain' => $domain,
                'issuer' => $domainRecord->ssl_issuer,
                'expirationDate' => $domainRecord->ssl_expiration_date,
                'isValid' => $domainRecord->SSL_is_valid,
            ];
        } catch (\Exception $e) {
            DB::rollback();
            $data = [
                'domain' => $domain,
                'error' => 'Failed to fetch SSL details. ' . $e->getMessage(),
            ];
        }
        return view('monitoring.show', compact('data'));
    }
}
