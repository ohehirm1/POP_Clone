<?php

namespace Tests\Feature\Models;

use App\Enums\Role;
use App\Models\Allocation;
use App\Models\Business;
use App\Models\MaxPrice;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllocationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check if a provider user can see
     * the allocation index without
     * getting redirected
     *
     * @return void
     */
    public function test_a_provider_can_see_allocation_index(): void
    {
        $user = User::factory()->create([
            'role' => Role::Provider,
        ]);
        $user = User::find($user->id);
        $resp = $this->actingAs($user)->get('/allocations');
        $resp->assertOk();
        $resp->assertSeeText('Allocations');
    }

    public function test_an_admin_gets_redirected_to_dashboard_on_allocation_index()
    {
        $user = User::factory()->create([
            'role' => Role::Admin,
        ]);
        $user = User::find($user->id);
        $resp = $this->actingAs($user)->get('/allocations');
        $resp->assertRedirect('/dashboard');
    }

    public function test_a_staff_gets_redirected_to_dashboard_on_allocation_index()
    {
        $user = User::factory()->create([
            'role' => Role::Staff,
        ]);
        $user = User::find($user->id);
        $resp = $this->actingAs($user)->get('/allocations');
        $resp->assertRedirect('/dashboard');
    }

    public function test_allocation_factory_can_create_a_record()
    {
        $user = User::factory()->create([
            'role' => Role::Provider,
        ]);
        Business::factory()->verified()->create();
        Participant::factory()->verified()->create();
        Allocation::factory(11)->create();
        $this->assertCount(11, Allocation::all());
    }

    public function test_allocation_index_pagination_shows_when_more_than_10_records()
    {
        $user = User::factory()->create([
            'role' => Role::Provider,
        ]);
        $user = User::find($user->id);
        Business::factory()->verified()->create();
        Participant::factory()->verified()->create();
        Allocation::factory(11)->create();
        $resp = $this->actingAs($user)->get('/allocations');
        $resp->assertOk();
        $resp->assertSeeText('Allocations');
        $resp->assertSeeText('1');
        $resp->assertSeeText('2');
    }

    public function test_provider_can_see_create_allocation_page_properly()
    {
        $user = User::factory()->create([
            'role' => Role::Provider,
        ]);
        $user = User::find($user->id);
        $resp = $this->actingAs($user)->get('/allocations/create');
        $resp->assertOk();
        $resp->assertSeeText('Add');
        $resp->assertSeeText('Allocated Amount');
    }

    public function test_staff_gets_redirected_to_dashboard_on_create_allocation_page()
    {
        $user = User::factory()->create([
            'role' => Role::Staff,
        ]);
        $user = User::find($user->id);
        $resp = $this->actingAs($user)->get('/allocations/create');
        $resp->assertRedirect('dashboard');
    }

    public function test_admin_gets_redirected_to_dashboard_on_create_allocation_page()
    {
        $user = User::factory()->create([
            'role' => Role::Admin,
        ]);
        $user = User::find($user->id);
        $resp = $this->actingAs($user)->get('/allocations/create');
        $resp->assertRedirect('dashboard');
    }

    public function test_a_provider_can_create_an_allocation()
    {
        $user = User::factory()->create([
            'role' => Role::Provider,
        ]);
        $user = User::find($user->id);
        Business::factory()->verified()->create();
        Participant::factory()->verified()->create();
        MaxPrice::factory()->create();
        $data = [
            'business_id' => fake()->randomElement(Business::whereNotNull('verified_at')->get()->pluck('id')),
            'participant_id' => fake()->randomElement(Participant::whereNotNull('verified_at')->get()->pluck('ndis')),
            'support_item' => fake()->randomElement(MaxPrice::all()->pluck('item')),
            'start_date' => now()->subDays(5)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
            'price_charged' => fake()->numerify('##.##'),
            'allocated_amount' => fake()->numerify('###.##'),
            'created_by' => fake()->randomElement(User::whereRole(Role::Provider)->get()->pluck('id')),
        ];
        $response = $this->actingAs($user)->post('/allocations', $data);
        $response->assertRedirect('/allocations');
        $this->assertModelExists(Allocation::where('support_item', '=', $data['support_item'])->first());
        $this->assertModelExists(Allocation::where('end_date', '=', $data['end_date'])->first());
    }
}
