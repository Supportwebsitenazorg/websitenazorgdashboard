<?php

// php artisan fetch:pagespeed to use this command single handedly :)
// cd 'XX\XX\XX'; php artisan schedule:run to use this command with the scheduler :)


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Domain;
use App\Models\PageSpeedInsight;
use GuzzleHttp\Client;

class FetchPageSpeed extends Command
{
    protected $signature = 'fetch:pagespeed';
    protected $description = 'Fetches PageSpeed insights for all domains and stores them in the database';


    public function handle()
    {
        ini_set('memory_limit', '256M');

        $domains = Domain::all()->pluck('domain');
        $apiKey = env('AIzaSyBeR0hF-fssZrYav078Y8LzTGtCLaayESU');
        $client = new Client(['verify' => false]);

        foreach ($domains as $domain) {
            unset($variable);

            $this->info("Fetching insights for domain: {$domain}");

            $url = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=https://{$domain}&key={$apiKey}";
    
            try {
                $mobileResponse = $client->request('GET', $url . "&strategy=mobile");
                $desktopResponse = $client->request('GET', $url . "&strategy=desktop");

                $mobileData = json_decode($mobileResponse->getBody()->getContents(), true);
                $desktopData = json_decode($desktopResponse->getBody()->getContents(), true);

                PageSpeedInsight::updateOrCreate(
                    ['domain' => $domain],
                    [
                        'mobile_insights' => json_encode($mobileData),
                        'desktop_insights' => json_encode($desktopData)
                    ]
                );

                $this->info("Successfully fetched insights for domain: {$domain}");
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                $response = $e->getResponse();
                if ($response->getStatusCode() == 429) {
                    $retryAfter = $response->getHeader('Retry-After');
                    $retrySeconds = is_array($retryAfter) ? reset($retryAfter) : $retryAfter;
                    $retrySeconds = max(1, (int)$retrySeconds);
    
                    $this->warn("Rate limit hit. Retrying after {$retrySeconds} seconds.");
                    sleep($retrySeconds);
                } else {
                    $this->error("Failed for domain {$domain}: " . $e->getMessage());
                }
            }
        }
    
        $this->info('All done!');
    }
}
