<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */

    // Author creation
    public function an_author_can_be_created()
    {
        $this->post('/author',[
            'name'=> 'author name',
            'dob'=>'17-11-1993',
        ]);
        $author = Author::all();
        $this->assertCount(1, $author);

        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1993-11-17', $author->first()->dob->format('Y-m-d'));
    }
}
