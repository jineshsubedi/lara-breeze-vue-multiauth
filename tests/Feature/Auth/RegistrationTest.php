<?php

namespace Tests\Feature\Auth;

use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest 
{
    use RefreshDatabase;

    // public function test_registration_screen_can_be_rendered()
    // {
    //     Setting::factory()->create();
    //     $response = $this->get('/register');

    //     $response->assertStatus(200);
    // }

    // public function test_new_users_can_register()
    // {
    //     $response = $this->post('/register', [
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //         'password' => 'Pa55w0rd123#',
    //         'password_confirmation' => 'Pa55w0rd123#',
    //     ]);

    //     $this->assertAuthenticated();
    //     $response->assertRedirect(RouteServiceProvider::HOME);
    // }
}