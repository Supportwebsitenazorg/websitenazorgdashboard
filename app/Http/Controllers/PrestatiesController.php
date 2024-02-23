<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\PageSpeedInsight;

class PrestatiesController extends Controller
{
    public function prestaties($domain) {
        $insights = PageSpeedInsight::where('domain', $domain)->first();
    
        if ($insights) {
            $mobileInsights = json_decode($insights->mobile_insights, true);
            $desktopInsights = json_decode($insights->desktop_insights, true);
    
            return view('monitoring.prestaties', [
                'domain' => $domain,
                'mobileInsights' => $mobileInsights,
                'desktopInsights' => $desktopInsights
            ]);
        } else {
            return view('monitoring.prestaties', [
                'domain' => $domain,
                'error' => __('messages.no_insights_found')
            ]);
        }
    }
    
}