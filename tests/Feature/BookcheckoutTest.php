<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookcheckoutTest extends TestCase
{
    use RefreshDatabase;    

    /** @test */
    public function a_book_can_be_checked_out_by_a_signed_in_user()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/checkout/'.$book->id);
        
        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->id);
        $this->assertEquals($book->id, Reservation::first()->id);
        $this->assertEquals(now() , Reservation::first()->checked_out_at);
    } 

    /** @test */
    public function only_signed_in_users_can_checked_a_book()
    {
        // $this->withoutExceptionHandling();
        $book = Book::factory()->create();

        $response = $this->post('/checkout/'.$book->id)
            ->assertRedirect('/login');

        $this->assertCount(0, Reservation::all());
    }

    /** @test */
    public function only_real_book_can_be_checkout()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
        ->post('->checkout/111')
        ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }
}
