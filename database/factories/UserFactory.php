<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName('female'),
            'avatar' => null,
            'description' => null,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function downloadAvatar(): static
    {
        return $this->state(function (array $attributes) {
            $imgData = json_decode(file_get_contents("https://nekos.best/api/v2/waifu"));
            $url = $imgData->results[0]->url;
    
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $file = '/tmp/' . $info['basename'];
            file_put_contents($file, $contents);
            $uploaded_file = new UploadedFile($file, $info['basename']);
            
            $avatar = Storage::disk("public")->put('avatar', $uploaded_file);

            return [
                'avatar' => $avatar,
                'description' => $imgData->results[0]->source_url,
            ];
        });
    }
}
