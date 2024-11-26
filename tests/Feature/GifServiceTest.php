<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GifServiceTest extends TestCase
{

    public function test_search_gifs()
    {
        $token = $this->user->createToken('test-token')->plainTextToken;
        $response = $this->getJson('/api/gifs/search?query=funny&limit=5', ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'embed_url',
                        'id',
                        'slug',
                        'title',
                        'type',
                        'url',
                    ],
                ],
                'meta' => [
                    'status',
                    'msg',
                ],
                'pagination' => [
                    'count',
                    'offset',
                    'total_count',
                ],
                'status',
            ]);
    }
    public function test_save_favorite_gif()
    {
        $token = $this->user->createToken('test-token')->plainTextToken;


        $response = $this->postJson('/api/gifs/user/save', [
            'gif_id' => 'DirPxXrUHKaCA',
            'user_id' => $this->user->id,
        ], ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => 'DirPxXrUHKaCA',
                'status' => 'success',
                'message' => 'GIF saved',
            ]);
    }
}
