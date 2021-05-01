<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_get_user_info()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('user.show'));

        $response->assertJsonFragment($user->toArray());
    }
}
