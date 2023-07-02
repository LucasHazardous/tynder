<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Relation>
 */
class RelationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $other_users = User::count()-1;
        $creator_id = DB::select("SELECT id FROM users WHERE (SELECT COUNT(target_id) FROM relations WHERE creator_id=users.id) < $other_users ORDER BY RAND() LIMIT 1;")[0]->id;

        $target_id = User::select('id')
        ->where('id', '!=', $creator_id)
        ->whereNotIn('id', function ($query) use ($creator_id) {
            $query->select('target_id')
                ->from('relations')
                ->where('creator_id', $creator_id);
        })->first()->id;

        return [
            "creator_id" => $creator_id,
            "target_id" => $target_id,
            "likes" => fake()->randomElement([true, false])
        ];
    }
}
