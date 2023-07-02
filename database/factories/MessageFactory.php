<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $connected_pairs = DB::select("SELECT creator_id, target_id
        FROM relations AS outerRelations
        WHERE EXISTS (SELECT creator_id, target_id
        FROM relations
        WHERE outerRelations.creator_id=target_id and outerRelations.target_id=creator_id 
        AND likes=1) 
        AND likes=1");

        $connected_pair = fake()->randomElement($connected_pairs);
        return [
            "sender" => $connected_pair->creator_id,
            "receiver" => $connected_pair->target_id,
            "content" => fake()->sentence()
        ];
    }
}
