<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_check_authentication()
    {
        $response = $this->getJson(route('auth.check'));

        $response->assertOk();
        $response->assertJson(['data' => false]);

        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->getJson(route('auth.check'));

        $response->assertOk();
        $response->assertJson(['data' => true]);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->postJson('login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertOk();
    }

    public function test_login_attempt_when_already_authenticated_throws_error()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(418);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->postJson('login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertStatus(422);
    }

    public function test_users_can_logout()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->postJson('logout');

        $this->assertGuest();
        $response->assertStatus(204);
    }
}
