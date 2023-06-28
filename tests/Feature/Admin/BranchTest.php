<?php

namespace Tests\Feature\Admin;

use App\Models\Branch;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class BranchTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'SuperAdmin']);
        $this->user = User::factory()->create(['staff_type' => 1]);
    }
    
    public function test_index_method_returns_correct_data()
    {
        $response = $this->get(route('admin.branches.index'));
        $response->assertStatus(302);
    }
    public function test_store_method_creates_branch_and_redirects_to_index()
    {
        $this->actingAs(User::factory()->create(['staff_type' => 1]));
        // set up sample data
        $data = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'description' => fake()->text(),
            'province_id' => 1,
            'district_id' => 1,
        ];
        // make request
        $response = $this->post(route('admin.branches.store'), $data);
        // check redirect
        $response->assertStatus(302);
    }

    public function test_store_method_validates_request_data()
    {
        Role::create(['name' => 'SuperAdmin']);
        $user = User::factory()->create([
            'staff_type' => 1
        ]);
        // make request with invalid data
        $data = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'description' => fake()->text(),
            'province_id' => 1,
            'district_id' => 1,
        ];
        $response = $this->actingAs($user)->post(route('admin.branches.store'), $data);
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.branches.create'));
    }

    public function test_destroy_branch()
    {
        $branch = Branch::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('admin.branches.destroy', $branch->id));

        $response->assertRedirect(route('admin.branches.index'));
    }
}
