<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;
use App\Models\User;
use App\Models\Domain;
use App\Models\PageSpeedInsightHistory;

class PrestatiesControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        // setup van de test (gate policies bypassen)
        parent::setUp();
        Gate::before(function ($user, $ability) {
            return true;
        });
    }

    /** @test */
    public function DomainWithInsights()
    {
        // auth user mocken
        $user = User::factory()->create();
        Auth::login($user);

        $domain = Domain::create(['domain' => 'www.nijmegen.nl']);
        PageSpeedInsightHistory::create([
            'domain' => 'www.nijmegen.nl',
            'date' => now()->toDateString(),
            'mobile_insights' => json_encode(['lighthouseResult' => ['categories' => ['performance' => ['score' => 0.9]]]]),
            'desktop_insights' => json_encode(['lighthouseResult' => ['categories' => ['performance' => ['score' => 0.95]]]])
        ]);

        $response = $this->get('/monitoring/' . $domain->domain . '/prestaties');

        // response controleren (moet 200 zijn)
        $response->assertStatus(200);
        $response->assertViewIs('monitoring.prestaties');
        $response->assertViewHas('domain', $domain->domain);
        $response->assertViewHas('insights');
        $response->assertViewHas('todayInsights');
    }

    /** @test */
    public function DomainWithoutInsights()
    {
        // auth van user mocken
        $user = User::factory()->create();
        Auth::login($user);

        // domein die niet bestaat aanmaken
        $domain = Domain::create(['domain' => 'www.bestaatniet.nl']);

        // respsonse moet 200 zijn en de view moet no insights found bevatten
        $response = $this->get('/monitoring/' . $domain->domain . '/prestaties');
        $response->assertStatus(200);
        $response->assertViewIs('monitoring.prestaties');
        $response->assertSeeText(__('messages.no_insights_found'));
    }
}
