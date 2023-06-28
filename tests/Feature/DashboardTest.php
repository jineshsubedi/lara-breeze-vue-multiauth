<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_dashboard_load_view()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertStatus(302);
    }
}
