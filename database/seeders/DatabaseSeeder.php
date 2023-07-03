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
        $this->command->getOutput()->progressStart(301);
        
        User::factory(20)->downloadAvatar()->create();
        $this->command->getOutput()->progressAdvance();

        for($i = 0; $i < 300; $i++) {
            Relation::factory(1)->create();
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();

        error_log("Attempting to generate messsages.");

        try {
            Message::factory(20)->create();
            error_log("Successfully generated messsages.");
        } catch (\Throwable $th) {
            error_log("Messages can not be generated.");
        }
    }
}
