<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PrestatiesController extends Controller
{
    public function prestaties($domain) {
        $client = new Client(['verify' => storage_path('app/certs/cacert.pem')]);

        $apiKey = "AIzaSyBeR0hF-fssZrYav078Y8LzTGtCLaayESU";
        $baseURL = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=http://{$domain}&key={$apiKey}";

        try {
            $mobileResponse = $client->request('GET', $baseURL . "&strategy=mobile");
            $mobileData = json_decode($mobileResponse->getBody()->getContents(), true);

            $desktopResponse = $client->request('GET', $baseURL . "&strategy=desktop");
            $desktopData = json_decode($desktopResponse->getBody()->getContents(), true);

            if ($mobileResponse->getStatusCode() == 200 && $desktopResponse->getStatusCode() == 200) {
                return view('monitoring.prestaties', ['domain' => $domain, 'mobileInsights' => $mobileData, 'desktopInsights' => $desktopData]);
            } else {
                return view('monitoring.prestaties', ['domain' => $domain, 'error' => 'Failed to fetch PageSpeed Insights.']);
            }
        } catch (RequestException $e) {
            $errorMessage = 'Failed to fetch PageSpeed Insights due to an error.';
            if ($e->hasResponse()) {
                $errorMessage .= ' Error: ' . $e->getMessage();
            }
            return view('monitoring.prestaties', ['domain' => $domain, 'error' => $errorMessage]);
        }
    }
}
