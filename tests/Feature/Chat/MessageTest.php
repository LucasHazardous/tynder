<?php

namespace Tests\Feature\Chat;

use App\Models\Relation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_message_to_connected_user(): void
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

        $response = $this->actingAs($mainUser)->post('/chat', [
            "receiver" => $otherUser->id,
            "content" => fake()->sentence()
        ]);

        $response->assertRedirect();
    }

    public function test_send_message_to_unconnected_user(): void
    {
        $otherUser = User::factory()->create();

        $mainUser = User::factory()->create();

        $response = $this->actingAs($mainUser)->post('/chat', [
            "receiver" => $otherUser->id,
            "content" => fake()->sentence()
        ]);

        $response->assertForbidden();
    }

    public function test_receive_message_from_connected_user(): void
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

        $message = fake()->sentence();

        $response = $this->actingAs($otherUser)->post('/chat', [
            "receiver" => $mainUser->id,
            "content" => $message
        ]);

        $response->assertRedirect();

        $response = $this->actingAs($mainUser)->get('/chat/' . $otherUser->id);

        $response->assertViewHas('messages', function ($messages) use ($message) {
            return $messages->first()->content == $message;
        });
    }

    public function test_check_messages_from_unconnected_user(): void
    {
        $otherUser = User::factory()->create();

        $mainUser = User::factory()->create();

        $response = $this->actingAs($mainUser)->get('/chat/' . $otherUser->id);

        $response->assertForbidden();
    }
}
