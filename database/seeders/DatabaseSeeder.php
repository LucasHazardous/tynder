<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();
        for($i = 0; $i < 30; $i++) {
            Relation::factory(1)->create();
        }
        try {
            Message::factory(20)->create();
        } catch (\Throwable $th) {
            error_log("Messages can not be generated.");
        }
    }
}
