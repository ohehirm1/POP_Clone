<?php

namespace Tests\Feature\Models;

use App\Enums\AuthRole;
use App\Enums\Role;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipantTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_participant_can_be_created_in_factory(): void
    {
        User::factory()->create([
            'role' => Role::Provider,
        ]);

        $p = Participant::factory()->create([]);
        $this->assertTrue($p->exists());
    }

    public function test_create_participant_page_redirects_for_guests()
    {
        $response = $this->get('/participants/create');
        $response->assertRedirect('/login');
    }

    public function test_create_participant_page_renders_for_provider_user()
    {
        $user = User::factory()->create([
            'role' => Role::Provider,
        ]);
        $user = User::find($user->id);
        $response = $this->actingAs($user)->get('/participants/create');
        $response->assertOK();
        $response->assertDontSeeText('You need to be a provider to access this page!');
    }

    public function test_provider_user_can_create_participant()
    {
        $user = User::factory()->create([
            'role' => Role::Provider,
        ]);
        $user = User::find($user->id);
        $this->assertTrue($user->hasVerifiedEmail());
        $this->assertTrue($user->is_provider());
        $data = [
            'name' => fake()->name(),
            'ndis' => fake()->numerify('#########'),
            'auth_role' => fake()->randomElement(array_keys(AuthRole::cases())),
            'email' => fake()->safeEmail(),
        ];
        $response = $this->actingAs($user)->post('/participants', $data);
        $response->assertRedirect('/participants');
        $this->assertModelExists(Participant::whereNdis($data['ndis'])->first());
    }
}
