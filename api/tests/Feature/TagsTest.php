<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagsTest extends TestCase
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
        $response = $this->get('/tags');

        $tags = Tag::all();

        $response->assertStatus(200);
        $response->assertJson($tags->toArray());
    }

    public function test_successful_response_for_a_single_tag(): void
    {
        $tag = Tag::first();

        $response = $this->get('/tags/' . $tag->id);

        $response->assertStatus(200);
        $response->assertJson($tag->toArray());
    }

    public function test_not_found_response_for_an_invalid_tag(): void
    {
        $response = $this->get('/tags/999');

        $response->assertStatus(404);
    }

    public function test_successful_response_for_creating_a_tag(): void
    {
        $response = $this->post('/tags', [
            'name' => 'Tag Name',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'name' => 'Tag Name',
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => 'Tag Name',
        ]);
    }

    public function test_successful_response_for_updating_a_tag(): void
    {
        $tag = Tag::first();

        $response = $this->put('/tags/' . $tag->id, [
            'name' => 'Updated Tag Name',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'name' => 'Updated Tag Name',
        ]);
    }

    public function test_successful_response_for_deleting_a_tag(): void
    {
        $tag = Tag::first();

        $response = $this->delete('/tags/' . $tag->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id,
        ]);
    }
}
