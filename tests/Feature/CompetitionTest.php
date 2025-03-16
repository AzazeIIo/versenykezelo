<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\CompetitionController;
use App\Models\User;
use App\Models\Competition;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompetitionTest extends TestCase
{
    use DatabaseTransactions;

    private static $testData = [
        "name" => 'testname',
        "year" => '2000',
        "languages" => null,
        "right_ans" => null,
        "wrong_ans" => null,
        "empty_ans" => null,
    ];

    public function test_competitions_view_contains_the_word_Competitions(): void
    {
        $response = $this->get('/competitions');

        $response->assertSeeText('Competitions');
    }
    
    public function test_root_route_redirects_to_competitions_route(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('competitions');
    }

    public function test_competitions_route_returns_competitions_view(): void
    {
        $response = $this->get('/competitions');

        $response->assertStatus(200);
        $response->assertViewIs('Competitions.index');
    }
    
    public function test_competitions_view_has_competitions(): void
    {
        $response = $this->get('/competitions');

        $response->assertStatus(200);
        $response->assertViewHas('competitions');
    }

    public function test_competition_factory_is_working(): void
    {
        $competition = Competition::factory()->create();
 
        $this->assertModelExists($competition);
    }
    
    public function test_guest_cant_see_new_competition_form(): void
    {
        $response = $this->get('/competitions');

        $response->assertDontSee('newCompetitionForm');
    }

    public function test_user_cant_see_new_competition_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/competitions');

        $response->assertDontSee('newCompetitionForm');
    }

    public function test_admin_can_see_new_competition_form(): void
    {
        $user = User::factory()->create();
        $user['is_admin'] = true;

        $response = $this->actingAs($user)
            ->get('/competitions');

        $response->assertSee('newCompetitionForm');
    }
    
    public function test_guest_is_unauthorized_to_create_new_competition(): void
    {
        $response = $this->call('POST', 'competitions', ['_token' => csrf_token(), ...CompetitionTest::$testData]);

        $response->assertForbidden();
    }

    public function test_user_is_unauthorized_to_create_new_competition(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->call('POST', 'competitions', ['_token' => csrf_token(), ...CompetitionTest::$testData]);

        $response->assertForbidden();
    }
    
    public function test_admin_is_authorized_to_create_new_competition(): void
    {
        $user = User::factory()->create();
        $user['is_admin'] = true;

        $response = $this->actingAs($user)->call('POST', 'competitions', ['_token' => csrf_token(), ...CompetitionTest::$testData]);

        $response->assertOk();
    }
    
    public function test_new_competition_can_be_created(): void
    {
        $user = User::factory()->create();
        $user['is_admin'] = true;

        $response = $this->actingAs($user)->call('POST', 'competitions', ['_token' => csrf_token(), ...CompetitionTest::$testData]);

        $this->assertDatabaseHas('competitions', ['name' => CompetitionTest::$testData['name'], 'year' => CompetitionTest::$testData['year']]);
    }
    
    public function test_competitions_with_same_name_and_year_cant_be_created(): void
    {
        $user = User::factory()->create();
        $user['is_admin'] = true;

        $this->actingAs($user)->call('POST', 'competitions', ['_token' => csrf_token(), ...CompetitionTest::$testData]);

        $response = $this->actingAs($user)->call('POST', 'competitions', ['_token' => csrf_token(), ...CompetitionTest::$testData]);

        $response->assertInvalid();
    }
}
