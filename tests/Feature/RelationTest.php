<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_gets_recommendation(): void
    {
        $otherUser = User::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    
        $response->assertViewHas('user', function (User $user) use ($otherUser) {
            return $user->name === $otherUser->name;
        });
    }

    public function test_user_creates_relation(): void
    {
        $otherUser = User::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/relation', ['target_id' => $otherUser->id, 'likes' => 1]);

        $response->assertRedirect();

        $response = $this->actingAs($user)->post('/relation', ['target_id' => $otherUser->id, 'likes' => 1]);
    
        $response->assertForbidden();
    }
}
