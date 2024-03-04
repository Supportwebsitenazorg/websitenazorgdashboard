<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\SslCertificate\SslCertificate;
use App\Models\Domain;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    public function beveiliging($domain)
    {
        $url = $this->startsWithHttp($domain) ? $domain : 'https://' . $domain;

        try {
            $sslCertificate = SslCertificate::createForHostName($url);
            $headers = get_headers($url, 1);
            $headersJson = json_encode($headers);
            $phpVersion = isset($headers['X-Powered-By']) ? $headers['X-Powered-By'] : '0';

            $securityStatuses = $this->checkSecurityStatuses($headers, $sslCertificate);

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
                'securityStatuses' => $securityStatuses
            ];

        } catch (\Exception $e) {
            DB::rollback();

            $data = [
                'domain' => $domain,
                'error' => 'Failed to fetch SSL and header details. ' . $e->getMessage(),
                'securityStatuses' => $securityStatuses ?? []
            ];
        }

        return view('monitoring.beveiliging', [
            'data' => $data,
            'domain' => $domain,
        ]);
    }


    private function startsWithHttp($domain)
    {
        return preg_match('/^https?:\/\//', $domain);
    }

    private function checkSecurityStatuses($headers, $sslCertificate)
    {
        $securityStatuses = [];

        $expirationDate = Carbon::parse($sslCertificate->expirationDate());
        $daysUntilExpiration = $expirationDate->diffInDays(Carbon::now());

        $securityStatuses['SSL'] = $daysUntilExpiration > 30 ? 'Veilig' : ($daysUntilExpiration > 7 ? 'Risico' : 'Gevaarlijk');

        $server = $headers['Server'] ?? null;
        $poweredBy = $headers['X-Powered-By'] ?? null;
        $securityStatuses['ServerFingerprinting'] = ($server || $poweredBy) ? 'Gevaarlijk' : 'Veilig';

        $hsts = $headers['Strict-Transport-Security'] ?? null;
        $securityStatuses['StrictTransportSecurity'] = empty($hsts) ? 'Gevaarlijk' : 'Veilig';

        $referrerPolicyString = is_array($referrerPolicy) ? reset($referrerPolicy) : $referrerPolicy;
        $securityStatuses['ReferrerPolicy'] = in_array(strtolower($referrerPolicyString), [
            'no-referrer',
            'no-referrer-when-downgrade',
            'same-origin',
            'origin',
            'strict-origin',
            'strict-origin-when-cross-origin',
            'unsafe-url'
        ]) ? 'Veilig' : 'Gevaarlijk';

        $permissionsPolicy = $headers['Permissions-Policy'] ?? null;
        $securityStatuses['PermissionsPolicy'] = empty($permissionsPolicy) ? 'Veilig' : 'Gevaarlijk';

        $xFrameOptions = $headers['X-Frame-Options'] ?? null;
        $securityStatuses['XFrameOptions'] = empty($xFrameOptions) ? 'Gevaarlijk' : 'Veilig';

        $xXssProtection = $headers['X-XSS-Protection'] ?? null;
        $securityStatuses['XXssProtection'] = empty($xXssProtection) ? 'Gevaarlijk' : 'Veilig';

        $xContentTypeOptions = $headers['X-Content-Type-Options'] ?? null;
        $securityStatuses['XContentTypeOptions'] = strtolower($xContentTypeOptions) === 'nosniff' ? 'Veilig' : 'Gevaarlijk';

        $contentSecurityPolicy = $headers['Content-Security-Policy'] ?? null;
        $securityStatuses['ContentSecurityPolicy'] = empty($contentSecurityPolicy) ? 'Gevaarlijk' : 'Veilig';

        return $securityStatuses;
    }
}