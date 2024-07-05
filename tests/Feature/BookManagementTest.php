<?php

namespace Tests\Feature;

use App\Models\Book; // Ajoutez cette ligne
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());

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

        $book = Book::first();

        $response->assertSessionHasErrors(['author']);        
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        // Créer un livre initial
        $this->post('/books' ,[
            'title' => 'Cool Book Title',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        // Mettre à jour le livre avec l'ID correct
        $response = $this->patch( $book->path() , [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        // Vérifier que le livre a été mis à jour correctement
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        // Créer un livre initial
        $this->post('/books' ,[
            'title' => 'Cool Book Title',
            'author' => 'Victor',
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
    

}

