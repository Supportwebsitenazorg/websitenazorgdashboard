<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\SslCertificate\SslCertificate;

class MonitoringController extends Controller
{
    public function show($domain)
    {
        try {
            $sslCertificate = SslCertificate::createForHostName($domain);

            $data = [
                'domain' => $domain,
                'issuer' => $sslCertificate->getIssuer(),
                'expirationDate' => $sslCertificate->expirationDate(),
                'isValid' => $sslCertificate->isValid(),
            ];
        } catch (\Exception $e) {
            $data = [
                'domain' => $domain,
                'error' => 'Failed to fetch SSL details. ' . $e->getMessage(),
            ];
        }

        return view('monitoring.show', compact('data'));
    }
}
