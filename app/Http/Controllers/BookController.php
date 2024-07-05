<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // store
    public function store()
    {
        $book = Book::create($this->validateRequest());
        return redirect($book->path());
    }


    //update
    public function update(Book $book)
    {
        $book->update($this->validateRequest());
        return redirect($book->path());
    }


    // validate
    protected function validateRequest(){
        return request()->validate([
            "title"=> "required",
            "author"=>"required",
        ]);
    }

    //destroy

    public function destroy(Book $book){
        $book->delete();
        return redirect('/books');
    }
}