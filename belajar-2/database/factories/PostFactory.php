<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = fake()->sentence();
        $slug = Str::slug($judul) . '-' . fake()->numerify();

        $body = fake()->paragraphs(random_int(8, 12));
        $excerpt = Str::words(implode(" ", $body), random_int(40, 60));

        return [
            // 'user_id' => fake()->numberBetween(1, 10),
            'title' => $judul,
            'slug' => $slug,
            'excerpt' => $excerpt,
            'body' => implode("\n", $body)
        ];
    }
}
