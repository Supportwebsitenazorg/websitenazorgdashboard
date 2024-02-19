<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class PrestatiesController extends Controller
{
    public function prestaties($domain) {
        $client = new Client(['verify' => storage_path('app/certs/cacert.pem')]);

        $apiKey = "AIzaSyBeR0hF-fssZrYav078Y8LzTGtCLaayESU";
        $url = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=http://{$domain}&key={$apiKey}";
        
        $response = $client->request('GET', $url);
        
        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody()->getContents(), true);
            return view('monitoring.prestaties', ['domain' => $domain, 'insights' => $data]);
        } else {
            return view('monitoring.prestaties', ['domain' => $domain, 'error' => 'Failed to fetch PageSpeed Insights.']);
        }
        
    }
    
}
