<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory(10)->unverified()->create();

        Category::factory(5)->has(
            Post::factory(10)
                ->state(new Sequence(
                    [
                        'is_published' => true,
                        'published_at' => now()
                    ],
                    [
                        'is_published' => false,
                        'published_at' => null
                    ],
                ))
                ->hasTags(2)
        )->create();

        /*   Post::factory(50)->create(); */

        /*  Tag::factory(20)->create(); */


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
