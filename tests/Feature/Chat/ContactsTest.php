<?php

namespace Tests\Feature\Chat;

use App\Models\Relation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_get_connected_user_to_message_with(): void
    {
        $otherUser = User::factory()->create();

        $mainUser = User::factory()->create();

        Relation::insert([[
            "creator_id" => $mainUser->id,
            "target_id" => $otherUser->id,
            "likes" => 1
        ],[
            "creator_id" => $otherUser->id,
            "target_id" => $mainUser->id,
            "likes" => 1
        ]]);

        $response = $this->actingAs($mainUser)->get('/chat');

        $response->assertViewHas('users', function ($users) use ($otherUser) {
            return $users->first()->name === $otherUser->name;
        });
    }

    public function test_get_unconnected_user_to_message_with(): void
    {
        $otherUser = User::factory()->create();

        $mainUser = User::factory()->create();

        Relation::insert([[
            "creator_id" => $mainUser->id,
            "target_id" => $otherUser->id,
            "likes" => 1
        ],[
            "creator_id" => $otherUser->id,
            "target_id" => $mainUser->id,
            "likes" => 0
        ]]);

        $response = $this->actingAs($mainUser)->get('/chat');

        $response->assertViewHas('users', function ($users) {
            return count($users) == 0;
        });

        Relation::truncate();

        $response = $this->actingAs($mainUser)->get('/chat');

        $response->assertViewHas('users', function ($users) {
            return count($users) == 0;
        });
    }
}
