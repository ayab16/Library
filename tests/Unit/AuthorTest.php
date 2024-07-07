<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function only_name_is_required_to_create_an_author()
    {
        Author::firstOrCreate([
            "name"=> "john wick",
        ]);

        $this->assertCount(1, Author::all());
    }
}