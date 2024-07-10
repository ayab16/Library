<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookcheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    // store
    public function store(Book $book)
    {
        $book->checkout(auth()->user());
    }
}
