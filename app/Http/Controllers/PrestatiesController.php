<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\PageSpeedInsightHistory;
use Carbon\Carbon;

class PrestatiesController extends Controller
{
    public function prestaties($domain)
    {
        // check of het domein bestaat in de db.
        $domainExists = Domain::where('domain', $domain)->first();

        if ($domainExists) {
            // laatste 30 dagen insights ophalen
            $fromDate = Carbon::now()->subDays(30)->toDateString();
            $toDate = Carbon::now()->toDateString();
        
            // insights verzamelend van de laatste 30 dagen
            $last30DaysInsights = PageSpeedInsightHistory::where('domain', $domain)
                ->whereBetween('date', [$fromDate, $toDate])
                ->orderBy('date', 'desc')
                ->get(['date', 'mobile_insights', 'desktop_insights'])
                ->map(function ($record) {
                    $mobileScore = json_decode($record->mobile_insights, true);
                    $desktopScore = json_decode($record->desktop_insights, true);
                    return [
                        'date' => $record->date,
                        'mobile_score' => $mobileScore['lighthouseResult']['categories']['performance']['score'] ?? null,
                        'desktop_score' => $desktopScore['lighthouseResult']['categories']['performance']['score'] ?? null,
                    ];
                });

            $mostRecentInsights = $last30DaysInsights->first();

            // return de view met de insights
            return view('monitoring.prestaties', [
                'domain' => $domain,
                'insights' => $last30DaysInsights,
                'todayInsights' => $mostRecentInsights,
            ]);
        } else {
            // return de view met een error "Geen inzichten gevonden"
            return view('monitoring.prestaties', [
                'domain' => $domain,
                'error' => __('messages.no_insights_found')
            ]);
        }
    }    
}
