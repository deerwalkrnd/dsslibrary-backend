<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowBookTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_book_can_be_borrowed()
    {
        $this->actingAs(\App\Models\User::factory()->create());
        $book = \App\Models\Book::factory()->create();
        $data = ['checkout_date' => 'Test Book', 'book_id' => $book->id,'user_id' => 1];
        $response = $this->post(route('checkout'), $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('borrow_records', $data);
    }

    public function test_book_can_be_returned()
{
    $this->actingAs(\App\Models\User::factory()->create());
    $borrow_record = \App\Models\BorrowRecord::factory()->create();

    $data = ['checkin_date' => now()->toDateString()];
    $response = $this->post(route('checkin',$borrow_record->id), $data);
    $response->assertStatus(200);
    $this->assertDatabaseHas('borrow_records', $data);
}
public function test_records_can_be_viewed()
    {
        $this->actingAs(\App\Models\User::factory()->create());
        \App\Models\BorrowRecord::factory()->create();
        
        $response = $this->get(route('allBooks'));
        $response->assertStatus(200);
        $this->assertDatabaseHas('borrow_records');
    }
    public function test_my_records_can_be_viewed()
    {
        $this->actingAs(\App\Models\User::factory()->create());
        \App\Models\BorrowRecord::factory()->create();
        $data=['user_id'=>1];
        $response = $this->get(route('myBooks'),$data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('borrow_records');
    }
}
