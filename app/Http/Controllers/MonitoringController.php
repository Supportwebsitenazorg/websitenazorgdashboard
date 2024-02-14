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
        // Ensure the domain starts with a scheme
        $url = $this->startsWithHttp($domain) ? $domain : 'https://' . $domain;

        try {
            // Fetch SSL certificate details
            $sslCertificate = SslCertificate::createForHostName($url);
            // Fetch the headers
            $headers = get_headers($url, 1); // 1 to use associative array
            $headersJson = json_encode($headers); // Convert headers to JSON to store in TEXT type
            

            DB::beginTransaction();

            // Update or create the domain record with SSL and headers information
            $domainRecord = Domain::updateOrCreate(
                ['domain' => $domain],
                [
                    'ssl_issuer' => $sslCertificate->getIssuer(),
                    'ssl_expiration_date' => $sslCertificate->expirationDate(),
                    'ssl_is_valid' => $sslCertificate->isValid() ? 1 : 0,
                    'headers' => $headersJson,
                    'updated_at' => now()  // Assuming you want to set this to the current time
                ]
            );

            DB::commit();

            // Prepare data for the view
            $data = [
                'domain' => $domain,
                'issuer' => $domainRecord->ssl_issuer,
                'expirationDate' => $domainRecord->ssl_expiration_date,
                'isValid' => $domainRecord->SSL_is_valid,
                // Add headers to the data array if you want to show them in the view
                'headers' => $headers
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

    /**
     * Check if the domain starts with http:// or https://
     *
     * @param string $domain
     * @return bool
     */
    private function startsWithHttp($domain)
    {
        return preg_match('/^https?:\/\//', $domain);
    }
}