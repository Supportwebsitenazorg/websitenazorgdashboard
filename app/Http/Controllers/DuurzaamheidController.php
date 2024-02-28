<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarbonData; 

class DuurzaamheidController extends Controller
{
    public function duurzaamheid($domain) {
        $carbonData = CarbonData::where('domain', $domain)->first();
    
        if ($carbonData) {
            $carbonDetails = json_decode($carbonData->data, true);
    
            return view('monitoring.duurzaamheid', [
                'domain' => $domain,
                'carbonDetails' => $carbonDetails,
            ]);
        } else {
            return view('monitoring.duurzaamheid', [
                'domain' => $domain,
                'error' => __('No carbon data found for this domain')
            ]);
        }
    }
}
