<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book; // Ajoutez cette ligne
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Util\Test;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        // $this->withoutExceptionHandling();

        $response = $this->post('/books',  $this->data());

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());

    }

    /** @test */

    public function a_title_is_required()
    {        
        $response = $this->post('/books', array_merge(  $this->data() , ['title' => '']));

        $response->assertSessionHasErrors(['title']);      
    }

    /** @test */
    public function an_author_is_required()
    {        
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author_id' => '',
        ]);

        $book = Book::first();

        $response->assertSessionHasErrors(['author_id']);        
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        // Créer un livre initial
        $this->post('/books' , $this->data());

        $book = Book::first();

        // Mettre à jour le livre avec l'ID correct
        $response = $this->patch( $book->path() ,  [
            'title' => 'New Title',
            'author_id' => 'New Author',
        ]);

        // Vérifier que le livre a été mis à jour correctement
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);

        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        // Créer un livre initial
        $this->post('/books' ,[
            'title' => 'Cool Book Title',
            'author_id' => 'Victor',
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
    
    /** @test */
    public function a_new_author_is_automatically_added()
    { 
        $this->withoutExceptionHandling();

        // Créer un livre initial
        $this->post('/books' , $this->data());

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    protected function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Victor',
        ] ; 
    }

}

