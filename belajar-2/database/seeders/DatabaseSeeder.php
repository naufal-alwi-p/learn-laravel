<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $kategori = Category::factory(5)->create();

        $user = User::factory(10)->create();

        Post::factory(random_int(15, 30))->make()->each(function($post) use ($kategori, $user) {
            $post->user_id = $user->random()->id;
            $post->category_id = $kategori->random()->id;

            $post->save();
        });


                    
        // User::factory(10)
        //             ->has(Post::factory()->count(random_int(2, 7)), 'posts')
        //             ->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
