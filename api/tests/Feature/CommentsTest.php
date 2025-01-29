<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentsTest extends TestCase
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
        $response = $this->get('/comments');

        $comments = Comment::all();

        $response->assertStatus(200);
        $response->assertJson($comments->toArray());
    }

    public function test_successful_response_for_a_single_comment(): void
    {
        $comment = Comment::first();

        $response = $this->get('/comments/' . $comment->id);

        $response->assertStatus(200);
        $response->assertJson($comment->toArray());
    }

    public function test_not_found_response_for_an_invalid_comment(): void
    {
        $response = $this->get('/comments/999');

        $response->assertStatus(404);
    }

}
