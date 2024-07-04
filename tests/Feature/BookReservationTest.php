<?php

namespace Tests\Feature;

use App\Models\Book; // Ajoutez cette ligne
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Victor',
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */

    public function a_title_is_required()
    {        
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Victor',
        ]);

        $response->assertSessionHasErrors(['title']);
        
    }

    /** @test */
    public function an_author_is_required()
    {        
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => '',
        ]);

        $response->assertSessionHasErrors(['author']);
        
    }

    /** @test */
    public function a_book_can_be_updated()
    {        
        $this->withoutExceptionHandling();

        // Créer un livre initial
        $book = Book::create([
            'title' => 'Cool Book Title',
            'author' => 'Victor',
        ]);

        // Mettre à jour le livre avec l'ID correct
        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        // Vérifier que le livre a été mis à jour correctement
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}

