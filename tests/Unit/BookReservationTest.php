<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_checked_out()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->id);
        $this->assertEquals($book->id, Reservation::first()->id);
        $this->assertEquals(now() , Reservation::first()->checked_out_at);
    }

    /** @test */
    public function a_book_can_be_returned()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);
        $book->checkin($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->id);
        $this->assertEquals($book->id, Reservation::first()->id);
        $this->assertNotNull(Reservation::first()->checked_in_at);
        $this->assertEquals(now() , Reservation::first()->checked_out_at);
    }

    /** @test */
    public function a_book_can_be_checked_out_twice()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();
        $book->checkout($user);
        $book->checkin($user);

        $book->checkout($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::latest()->first()->id);
        $this->assertEquals($book->id, Reservation::latest()->first()->id);
        $this->assertEquals(now(), Reservation::latest()->first()->checked_out_at);

        $book->checkin($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id,  Reservation::latest()->first()->id);
        $this->assertEquals($book->id, Reservation::latest()->first()->id);
        $this->assertNotNull(Reservation::latest()->first()->checked_in_at);
        $this->assertEquals(now() , Reservation::latest()->first()->checked_out_at);
    }

    /** @test */
    public function if_not_checked_out_exception_is_thrown()
    {
        $this->expectException(\Exception::class);
        $book = Book::factory()->create();
        $user = User::factory()->create();
        
        $book->checkin($user);
    }
}
