<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Author;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * A basic test example.
     */
    public function test_successful_response(): void
    {
        $response = $this->get('/images');

        $images = Image::all();

        $response->assertStatus(200);
        $response->assertJson($images->toArray());
    }

    public function test_successful_response_for_a_single_image(): void
    {
        $image = Image::first();

        $response = $this->get('/images/' . $image->id);

        $response->assertStatus(200);
        $response->assertJson($image->toArray());
    }

    public function test_not_found_response_for_an_invalid_image(): void
    {
        $response = $this->get('/images/999');

        $response->assertStatus(404);
    }

    public function test_successful_response_for_creating_an_image(): void
    {
        $author = Author::first();
        $tag = Tag::first();

        $response = $this->post('/images', [
            'author_id' => $author->id,
            'title' => 'Image Title',
            'url' => 'https://example.com/image.jpg',
            'tags_ids' => [$tag->id],
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'author_id' => $author->id,
            'title' => 'Image Title',
            'url' => 'https://example.com/image.jpg',
            'tags' => [
                [
                    'id' => $tag->id,
                    'name' => $tag->name,
                ],
            ],
        ]);

        $this->assertDatabaseHas('images', [
            'author_id' => $author->id,
            'title' => 'Image Title',
            'url' => 'https://example.com/image.jpg',
        ]);
    }

    public function test_successful_response_for_updating_an_image(): void
    {
        $image = Image::first();

        $response = $this->put('/images/' . $image->id, [
            'title' => 'Updated Image Title',
            'url' => 'https://example.com/updated-image.jpg',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'title' => 'Updated Image Title',
            'url' => 'https://example.com/updated-image.jpg',
        ]);
    }

    public function test_successful_response_for_deleting_an_image(): void
    {
        $image = Image::first();

        $response = $this->delete('/images/' . $image->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('images', [
            'id' => $image->id,
        ]);
    }

    public function test_successful_response_for_creating_comment_on_an_image(): void
    {
        // create comment
        $image = Image::first();

        $response = $this->post('/images/' . $image->id . '/comments', [
            'body' => 'Comment Body',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'body' => 'Comment Body',
        ]);

        $this->assertDatabaseHas('comments', [
            'commentable_id' => $image->id,
            'commentable_type' => Image::class,
            'body' => 'Comment Body',
        ]);

        // get comments under an image
        $comment = $image->comments()->first();

        $response = $this->get('/images/' . $image->id . '/comments');

        $response->assertStatus(200);
        $response->assertJson([
            [
                'id' => $comment->id,
                'body' => $comment->body,
            ],
        ]);

        // load a single comment
        $response = $this->get('/comments/' . $comment->id);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $comment->id,
            'body' => $comment->body,
        ]);

        // delete comment
        $response = $this->delete('/comments/' . $comment->id);

        $response->assertStatus(204);

        // load comments under an image
        $response = $this->get('/images/' . $image->id . '/comments');

        $response->assertStatus(200);
        $response->assertJson([]);
    }
}
