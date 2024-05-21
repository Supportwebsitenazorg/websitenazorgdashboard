<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrivacyController extends Controller
{
    public function privacy($domain) {
        $trackers = $this->scrapeTrackers($domain);
        return view('monitoring.privacy', ['domain' => $domain, 'trackers' => $trackers]);
    }

    private function scrapeTrackers($url) {
        $client = new Client([
            'verify' => '../storage/app/certs/cacert.pem'
        ]);
        $response = $client->request('GET', $url);

        $cookies = $response->getHeader('Set-Cookie');

        $html = $response->getBody()->getContents();

        $crawler = new Crawler($html);
        $scripts = $crawler->filter('script')->each(function (Crawler $node, $i) {
            $scriptContent = $node->text();
            $srcContent = $node->attr('src') ?: '';

            $patterns = [
                'adservice.google.com' => 'Google Ad Services',
                'securepubads.g.doubleclick.net' => 'DoubleClick Secure Publisher Ads',
                'cdn.jsdelivr.net' => 'jsDelivr CDN',
                'stats.wp.com' => 'WordPress Stats',
                'fls-eu.amazon.com' => 'Amazon FLs Europe',
                'cm.g.doubleclick.net' => 'DoubleClick Campaign Manager',
                'adservice.google.nl' => 'Google Ad Services Netherlands',
                'google-analytics.com' => 'Google Analytics',
                'googletagmanager.com' => 'Google Tag Manager',
                'connect.facebook.net' => 'Facebook Pixel',
                'doubleclick.net' => 'Google DoubleClick',
                'fonts.googleapis.com' => 'Google Fonts',
                'fonts.gstatic.com' => 'Google GStatic',
                'google.com/recaptcha' => 'Google reCAPTCHA'
            ];
                       

            foreach ($patterns as $pattern => $name) {
                if (strpos($scriptContent, $pattern) !== false || strpos($srcContent, $pattern) !== false) {
                    return $name;
                }
            }
        });

        $trackers = array_filter($scripts);

        return [
            'cookies' => $cookies,
            'trackers' => $trackers
        ];
    }
}
