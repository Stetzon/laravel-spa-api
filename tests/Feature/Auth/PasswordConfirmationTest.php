<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_confirmed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('user/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertStatus(201);
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('user/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
    }

    public function test_password_confirm_status_can_be_retrieved()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('user/confirmed-password-status');

        $response->assertStatus(200);
        $response->assertJson(['confirmed' => false]);

        $this->actingAs($user)->postJson('user/confirm-password', [
            'password' => 'password',
        ]);
        $response = $this->actingAs($user)->getJson('user/confirmed-password-status');

        $response->assertJson(['confirmed' => true]);
    }
}
