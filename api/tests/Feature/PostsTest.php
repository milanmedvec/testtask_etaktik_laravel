<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostsTest extends TestCase
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
        $response = $this->get('/posts');

        $posts = Post::all();

        $response->assertStatus(200);
        $response->assertJson($posts->toArray());
    }

    public function test_successful_response_for_a_single_post(): void
    {
        $post = Post::first();

        $response = $this->get('/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertJson($post->toArray());
    }

    public function test_not_found_response_for_an_invalid_post(): void
    {
        $response = $this->get('/posts/999');

        $response->assertStatus(404);
    }

    public function test_successful_response_for_creating_a_post(): void
    {
        $author = Author::first();

        $response = $this->post('/posts', [
            'author_id' => $author->id,
            'title' => 'Post Title',
            'body' => 'Post Content',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'author_id' => $author->id,
            'title' => 'Post Title',
            'body' => 'Post Content',
        ]);

        $this->assertDatabaseHas('posts', [
            'author_id' => $author->id,
            'title' => 'Post Title',
            'body' => 'Post Content',
        ]);
    }

    public function test_successful_response_for_updating_a_post(): void
    {
        $post = Post::first();

        $response = $this->put('/posts/' . $post->id, [
            'title' => 'Updated Post Title',
            'body' => 'Updated Post Content',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'title' => 'Updated Post Title',
            'body' => 'Updated Post Content',
        ]);
    }

    public function test_successful_response_for_deleting_a_post(): void
    {
        $post = Post::first();

        $response = $this->delete('/posts/' . $post->id);

        $response->assertStatus(200);
    }

}
