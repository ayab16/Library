<?php

namespace Tests\Feature;

use PHPUnit\Util\Test;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookcheckinTest extends TestCase
{
    use RefreshDatabase;    

    /** @test */
    public function a_book_can_be_checked_in_by_a_signed_in_user()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/checkout/'. $book->id);
        
        $this->actingAs($user)
            ->post('/checkin/'. $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->id);
        $this->assertEquals($book->id, Reservation::first()->id);
        $this->assertEquals(now() , Reservation::first()->checked_out_at);
        $this->assertEquals(now() , Reservation::first()->checked_in_at);
    } 

    /** @test */
    public function only_signed_in_users_can_checkin_a_book()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/checkout/'.$book->id);
   
        Auth::logout(); 

        $this->post('/checkin/'.$book->id)
            ->assertRedirect('/login');

        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->checked_in_at);
    }

    /** @test */
    public function a_404_is_thrown_if_a_book_is_not_checkout_out_first()
    {
        $this->withoutExceptionHandling();

        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/checkin/'.$book->id)
            ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }
}
