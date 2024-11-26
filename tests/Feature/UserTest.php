<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_authenticated_user_details()
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $response = $this->getJson('/api/users/myuser');
        // dd($response);
        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }
}
