<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tags = Tag::factory(5)->create();

        $author1 = Author::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $author1->posts()->create([
            'title' => 'My first post',
            'body' => 'This is the body of my first post.',
        ])->tags()->attach($tags->random(2));
        $author1->posts()->create([
            'title' => 'My second post',
            'body' => 'This is the body of my second post.',
        ]);

        $author2 = Author::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
        ]);

        $image = $author2->images()->create([
            'title' => 'My first image',
            'url' => 'https://example.com/image.jpg',
        ]);
        $image->tags()->attach($tags->random(1));
        $image->comments()->create([
            'body' => 'This is a comment on the image.',
        ]);
    }
}
