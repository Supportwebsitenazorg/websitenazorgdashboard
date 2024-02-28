<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Domain;
use App\Models\CarbonData;
use GuzzleHttp\Client;

class FetchCarbonFootprint extends Command
{
    protected $signature = 'fetch:carbonfootprint';
    protected $description = 'Fetches carbon footprint data for all domains and stores them in the database';

    public function handle()
{
    ini_set('memory_limit', '256M');
    
    $allDomains = Domain::all()->pluck('domain');

    $startIndex = $allDomains->search('rudolphiedesign.nl');
    if ($startIndex === false) {
        $this->error("Domain not found.");
        return;
    }

    $domains = $allDomains->slice($startIndex);
    $client = new Client(['verify' => false]);

    foreach ($domains as $domain) {
        $this->info("Fetching carbon data for domain: {$domain}");

        $encodedUrl = urlencode("https://{$domain}");
        $url = "https://api.websitecarbon.com/site?url={$encodedUrl}";

        try {
            $response = $client->request('GET', $url);
            $data = $response->getBody()->getContents();

            CarbonData::updateOrCreate(
                ['domain' => $domain],
                ['data' => $data]
            );

            $this->info("Successfully fetched carbon data for domain: {$domain}");

            sleep(5);
        } catch (\Exception $e) {
            $this->error("Failed for domain {$domain}: " . $e->getMessage());
        }
    }

    $this->info('All done!');
}

}