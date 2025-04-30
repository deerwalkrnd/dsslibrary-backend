<?php

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use HasFactory,RefreshDatabase;
    protected $faker;
    /**
     * A basic feature test example.
     */
    public function test_book_can_be_created()
    {
        $this->actingAs(\App\Models\User::factory()->create());
        $data = ['title' => 'Test Book', 'author' => 'Jane Doe','uuid' => '78909'];
        $response = $this->post(route('books.store'), $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('books', $data);
    }

    public function test_book_can_be_viewed()
    {
        $this->actingAs(\App\Models\User::factory()->create());
        $book = \App\Models\Book::factory()->create();

        $response = $this->get(route('books.show', $book));
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
        ]);
    }

    public function test_book_can_be_updated()
    {
        $this->actingAs(\App\Models\User::factory()->create());
        $book = \App\Models\Book::factory()->create();

        $updatedData = ['title' => 'Updated Title', 'author' => 'Updated Author', 'uuid'=>'9807'];

        $response = $this->put(route('books.update', $book), $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $updatedData);
    }

    public function test_book_can_be_deleted()
    {
        $this->actingAs(\App\Models\User::factory()->create());
        $book = \App\Models\Book::factory()->create();

        $response = $this->delete(route('books.destroy', $book));
        $response->assertStatus(200); 

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

}
