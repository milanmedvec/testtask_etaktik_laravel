<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorsTest extends TestCase
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
        $response = $this->get('/authors');

        $authors = Author::all();

        $response->assertStatus(200);
        $response->assertJson($authors->toArray());
    }

    public function test_successful_response_for_a_single_author(): void
    {
        $author = Author::first();

        $response = $this->get('/authors/' . $author->id);

        $response->assertStatus(200);
        $response->assertJson($author->toArray());
    }

    public function test_not_found_response_for_an_invalid_author(): void
    {
        $response = $this->get('/authors/999');

        $response->assertStatus(404);
    }

    public function test_successful_response_for_creating_an_author(): void
    {
        $response = $this->post('/authors', [
            'first_name' => 'John ',
            'last_name' => 'Doe',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $this->assertDatabaseHas('authors', [
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
    }

    public function test_successful_response_for_updating_an_author(): void
    {
        $author = Author::first();

        $response = $this->put('/authors/' . $author->id, [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
        ]);

        $this->assertDatabaseHas('authors', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
        ]);
    }

    public function test_successful_response_for_deleting_an_author(): void
    {
        $author = Author::first();

        $response = $this->delete('/authors/' . $author->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('authors', [
            'id' => $author->id,
        ]);
    }
}
