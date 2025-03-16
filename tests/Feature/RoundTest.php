<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Competition;
use App\Models\Round;
use App\Models\User;

class RoundTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_can_access_rounds_of_a_competition(): void
    {
        $competition = Competition::factory()->create();

        $response = $this->get('/competitions/' . $competition['id'] . '/rounds');

        $response->assertOk();
    }

    public function test_route_to_a_competition_redirects_to_its_rounds(): void
    {
        $competition = Competition::factory()->create();

        $response = $this->get('/competitions/' . $competition['id']);

        $response->assertRedirect('/competitions/' . $competition['id'] . '/rounds');
    }

    public function test_rounds_route_returns_rounds_view(): void
    {
        $competition = Competition::factory()->create();

        $response = $this->get('/competitions/' . $competition['id'] . '/rounds');

        $response->assertStatus(200);
        $response->assertViewIs('Rounds.index');
    }
     
    public function test_rounds_view_has_competition(): void
    {
        $competition = Competition::factory()->create();

        $response = $this->get('/competitions/' . $competition['id'] . '/rounds');

        $response->assertStatus(200);
        $response->assertViewHas('competition');
    }
    
    public function test_rounds_view_has_rounds(): void
    {
        $competition = Competition::factory()->create();

        $response = $this->get('/competitions/' . $competition['id'] . '/rounds');

        $response->assertStatus(200);
        $response->assertViewHas('rounds');
    }

    public function test_round_factory_is_working(): void
    {
        Competition::factory()->create();
        $round = Round::factory()->create();
 
        $this->assertModelExists($round);
    }
    
    public function test_guest_cant_see_new_round_form(): void
    {
        $competition = Competition::factory()->create();

        $response = $this->get('/competitions/' . $competition['id'] . '/rounds');

        $response->assertDontSee('newRoundForm');
    }

    public function test_user_cant_see_new_round_form(): void
    {
        $competition = Competition::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/competitions/' . $competition['id'] . '/rounds');

        $response->assertDontSee('newRoundForm');
    }

    public function test_admin_can_see_new_round_form(): void
    {
        $competition = Competition::factory()->create();

        $user = User::factory()->create();
        $user['is_admin'] = true;

        $response = $this->actingAs($user)
            ->get('/competitions/' . $competition['id'] . '/rounds');

        $response->assertSee('newRoundForm');
    }
    
    public function test_guest_is_unauthorized_to_create_new_round(): void
    {
        $competition = Competition::factory()->create();

        $response = $this->call('POST', 'competitions/' . $competition['id'] . '/rounds', array(
                '_token' => csrf_token(),
                'competition_id' => $competition['id'],
                'round_number' => 0,
                'date' => "2000-01-01"
            ));

        $response->assertForbidden();
    }

    public function test_user_is_unauthorized_to_create_new_round(): void
    {
        $competition = Competition::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->call('POST', 'competitions/' . $competition['id'] . '/rounds', array(
                '_token' => csrf_token(),
                'competition_id' => $competition['id'],
                'round_number' => 0,
                'date' => "2000-01-01"
            ));

        $response->assertForbidden();
    }
    
    public function test_admin_is_authorized_to_create_new_round(): void
    {
        $competition = Competition::factory()->create();

        $user = User::factory()->create();
        $user['is_admin'] = true;

        $response = $this->actingAs($user)->call('POST', 'competitions/' . $competition['id'] . '/rounds', array(
                '_token' => csrf_token(),
                'competition_id' => $competition['id'],
                'round_number' => 0,
                'date' => "2000-01-01"
            ));

        $response->assertOk();
    }

    public function test_new_round_can_be_created(): void
    {
        $competition = Competition::factory()->create();

        $user = User::factory()->create();
        $user['is_admin'] = true;

        $response = $this->actingAs($user)->call('POST', 'competitions/' . $competition['id'] . '/rounds', array(
            '_token' => csrf_token(),
            'competition_id' => $competition['id'],
            'round_number' => 0,
            'date' => "2000-01-01"
        ));

        $this->assertDatabaseHas('rounds', ['competition_id' => $competition['id'], 'round_number' => 0]);
    }
    
    public function test_rounds_with_the_same_roundnumber_cant_be_created_for_the_same_competition(): void
    {
        $competition = Competition::factory()->create();

        $user = User::factory()->create();
        $user['is_admin'] = true;

        $this->actingAs($user)->call('POST', 'competitions/' . $competition['id'] . '/rounds', array(
            '_token' => csrf_token(),
            'competition_id' => $competition['id'],
            'round_number' => 0,
            'date' => "2000-01-01"
        ));

        $response = $this->actingAs($user)->call('POST', 'competitions/' . $competition['id'] . '/rounds', array(
            '_token' => csrf_token(),
            'competition_id' => $competition['id'],
            'round_number' => 0,
            'date' => "2000-01-01"
        ));

        $response->assertInvalid();
    }
    
    public function test_new_round_cant_be_added_to_nonexistent_competition(): void
    {
        $competition = Competition::factory()->create();

        $user = User::factory()->create();
        $user['is_admin'] = true;

        $response = $this->actingAs($user)->call('POST', 'competitions/' . $competition['id'] . '/rounds', array(
            '_token' => csrf_token(),
            'competition_id' => $competition['id']+1,
            'round_number' => 0,
            'date' => "2000-01-01"
        ));

        $response->assertInvalid();
    }
}
