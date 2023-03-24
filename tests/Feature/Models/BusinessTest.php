<?php

namespace Tests\Feature\Models;

use App\Enums\Role;
use App\Models\Business;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusinessTest extends TestCase
{
    use RefreshDatabase;

    public function test_business_can_be_created_in_factory()
    {
        User::factory()->create([
            'role' => Role::Provider,
        ]);

        $p = Business::factory()->create([]);
        $p_verified = Business::factory()->verified()->create([]);
        $this->assertTrue($p->exists());
        $this->assertTrue($p_verified->exists());
    }

    public function test_create_business_page_redirects_for_guests()
    {
        $response = $this->get('/businesses/create');
        $response->assertRedirect('/login');
    }

    public function test_create_business_page_renders_for_provider_user()
    {
        $user = User::factory()->create([
            'role' => Role::Provider,
        ]);
        $user = User::find($user->id);
        $response = $this->actingAs($user)->get('/businesses/create');
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
            'abn' => fake()->numerify('###########'),
        ];
        $response = $this->actingAs($user)->post('/businesses', $data);
        $response->assertRedirect('/businesses');
        $this->assertModelExists(Business::where('abn', '=', $data['abn'])->first());
    }
}
