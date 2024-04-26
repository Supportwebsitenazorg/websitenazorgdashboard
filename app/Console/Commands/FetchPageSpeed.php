<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Domain;
use App\Models\PageSpeedInsightHistory;
use GuzzleHttp\Client;

class FetchPageSpeed extends Command
{
    protected $signature = 'fetch:pagespeed';

    public function handle()
    {
        // memory limit verhogen naar 256M
        ini_set('memory_limit', '256M');

        // alle domeinen ophalen
        $domains = Domain::all()->pluck('domain');
        $apiKey = env('GOOGLE_PAGESPEED_API_KEY');
        $client = new Client(['verify' => false]);
        $sleepSeconds = 3;

        foreach ($domains as $domain) {
            $this->info("fetching: {$domain}");
            $url = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=https://{$domain}&key={$apiKey}";

            try {
                // insights ophalen voor mobile en desktop
                $mobileResponse = $client->request('GET', $url . "&strategy=mobile");
                sleep($sleepSeconds);

                $desktopResponse = $client->request('GET', $url . "&strategy=desktop");

                $mobileData = json_decode($mobileResponse->getBody()->getContents(), true);
                $desktopData = json_decode($desktopResponse->getBody()->getContents(), true);

                // insights opslaan in de db
                PageSpeedInsightHistory::create([
                    'domain' => $domain, 
                    'date' => now()->toDateString(),
                    'mobile_insights' => json_encode($mobileData),
                    'desktop_insights' => json_encode($desktopData),
                ]);

                $this->info("fetched: {$domain}");
            } catch (\Exception $e) {
                $this->error("failed {$domain}: " . $e->getMessage());
            }
        }

        $this->info('done');
    }
}
