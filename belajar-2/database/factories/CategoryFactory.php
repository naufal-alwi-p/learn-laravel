<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategori = fake()->unique()->randomElement(['Fisika', 'Kimia', 'Biologi', 'Matematika', 'Seni Rupa']);

        $slug = Str::slug($kategori);

        return [
            'category' => $kategori,
            'slug' => $slug
        ];
    }
}
