<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Competition;
use App\Models\Round;
use App\Models\User;
use App\Models\Competitor;


class CompetitorTest extends TestCase
{
    use DatabaseTransactions;
    
    private function insertTestRound()
    {
        Competition::factory()->create();
        $round = Round::factory()->create();

        return $round;
    }
    
    public function test_can_access_competitors_of_a_round(): void
    {
        $round = $this->insertTestRound();

        $response = $this->get('/competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors');

        $response->assertOk();
    }

    public function test_route_to_a_round_redirects_to_its_competitors(): void
    {
        $round = $this->insertTestRound();

        $response = $this->get('/competitions/' . $round['competition_id'] . '/rounds/' . $round['id']);

        $response->assertRedirect('/competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors');
    }

    public function test_competitors_route_returns_competitors_view(): void
    {
        $round = $this->insertTestRound();

        $response = $this->get('/competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors');

        $response->assertStatus(200);
        $response->assertViewIs('Competitors.index');
    }
     
    public function test_competitors_view_has_round(): void
    {
        $round = $this->insertTestRound();

        $response = $this->get('/competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors');

        $response->assertStatus(200);
        $response->assertViewHas('round');
    }
    
    public function test_competitors_view_has_competitors(): void
    {
        $round = $this->insertTestRound();

        $response = $this->get('/competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors');

        $response->assertStatus(200);
        $response->assertViewHas('competitors');
    }

    public function test_competitor_factory_is_working(): void
    {
        $round = $this->insertTestRound();
        User::factory()->create();

        $competitor = Competitor::factory()->create();
 
        $this->assertModelExists($competitor);
    }
    
    public function test_guest_cant_see_admin_forms(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();
        $competitor = Competitor::create(['round_id' => $round['id'],'user_id' => $user['id']]);

        $response = $this->get('/competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors');

        $response->assertDontSee('newCompetitorForm');
        $response->assertDontSee('removeCompetitorForm');
    }

    public function test_user_cant_see_admin_forms(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();
        $competitor = Competitor::create(['round_id' => $round['id'],'user_id' => $user['id']]);

        $response = $this->actingAs($user)
            ->get('/competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors');

        $response->assertDontSee('newCompetitorForm');
        $response->assertDontSee('removeCompetitorForm');
    }

    public function test_admin_can_see_admin_forms(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();
        $user['is_admin'] = true;
        $competitor = Competitor::create(['round_id' => $round['id'],'user_id' => $user['id']]);

        $response = $this->actingAs($user)
            ->get('/competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors');

        $response->assertSee('newCompetitorForm');
        $response->assertSee('removeCompetitorForm');
    }

    public function test_guest_is_unauthorized_to_create_new_competitor(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();

        $response = $this->call('POST', 'competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors', array(
                '_token' => csrf_token(),
                'round_id' => $round['id'],
                'user_id' => $user['id']
            ));

        $response->assertForbidden();
    }
    
    public function test_guest_is_unauthorized_to_remove_competitor(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();
        $competitor = Competitor::create(['round_id' => $round['id'],'user_id' => $user['id']]);

        $response = $this->call('DELETE', 'competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors/' . $competitor['id'], array(
                '_token' => csrf_token(),
            ));

        $response->assertForbidden();
    }

    public function test_user_is_unauthorized_to_create_new_competitor(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->call('POST', 'competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors', array(
                '_token' => csrf_token(),
                'round_id' => $round['id'],
                'user_id' => $user['id']
            ));

        $response->assertForbidden();
    }
    
    public function test_user_is_unauthorized_to_remove_competitor(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();
        $competitor = Competitor::create(['round_id' => $round['id'],'user_id' => $user['id']]);

        $response = $this->actingAs($user)->call('DELETE', 'competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors/' . $competitor['id'], array(
                '_token' => csrf_token(),
            ));

        $response->assertForbidden();
    }
    
    public function test_admin_is_authorized_to_create_new_competitor(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();
        $user['is_admin'] = true;

        $response = $this->actingAs($user)->call('POST', 'competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors', array(
                '_token' => csrf_token(),
                'round_id' => $round['id'],
                'user_id' => $user['id']
            ));

        $response->assertOk();
    }
    
    public function test_admin_is_authorized_to_remove_competitor(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();
        $user['is_admin'] = true;
        $competitor = Competitor::create(['round_id' => $round['id'],'user_id' => $user['id']]);

        $response = $this->actingAs($user)->call('DELETE', 'competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors/' . $competitor['id'], array(
                '_token' => csrf_token()
            ));

        $response->assertOk();
    }

    public function test_new_competitor_can_be_created(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();
        $user['is_admin'] = true;

        $response = $this->actingAs($user)->call('POST', 'competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors', array(
            '_token' => csrf_token(),
            'round_id' => $round['id'],
            'user_id' => $user['id']
        ));

        $this->assertDatabaseHas('competitors', ['round_id' => $round['id'], 'user_id' => $user['id']]);
    }
    
    public function test_user_cant_be_assigned_to_the_same_round_twice(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();
        $user['is_admin'] = true;

        $this->actingAs($user)->call('POST', 'competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors', array(
            '_token' => csrf_token(),
            'round_id' => $round['id'],
            'user_id' => $user['id']
        ));

        $response = $this->actingAs($user)->call('POST', 'competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors', array(
            '_token' => csrf_token(),
            'round_id' => $round['id'],
            'user_id' => $user['id']
        ));

        $response->assertInvalid();
    }
    
    public function test_new_competitor_cant_be_added_to_nonexistent_round(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();
        $user['is_admin'] = true;

        $response = $this->actingAs($user)->call('POST', 'competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors', array(
            '_token' => csrf_token(),
            'round_id' => $round['id']+1,
            'user_id' => $user['id']
        ));

        $response->assertInvalid();
    }
    
    public function test_nonexistent_user_cant_be_assigned_to_a_round(): void
    {
        $round = $this->insertTestRound();
        $user = User::factory()->create();
        $user['is_admin'] = true;

        $response = $this->actingAs($user)->call('POST', 'competitions/' . $round['competition_id'] . '/rounds/' . $round['id'] . '/competitors', array(
            '_token' => csrf_token(),
            'round_id' => $round['id'],
            'user_id' => $user['id']+1
        ));

        $response->assertInvalid();
    }
}
