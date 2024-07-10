<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class authorController extends Controller
{
    // store
    public function store()
    {
        $author = Author::create($this->validateRequest());
    }

    protected function validateRequest()
    {
        return request()->validate(
            [
                "name"=> 'required',
                "dob"=> 'required',
            ]);
    }
}
