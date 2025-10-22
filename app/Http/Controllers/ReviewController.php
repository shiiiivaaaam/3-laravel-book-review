<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function __construct(){
        $this->middleware('throttle:reviews')->only(['store']);
    }
    public function create(Book $book)
    {
         return view('books.reviews.create',compact('book'));
    }


    public function store(Book $book)
    {
        $data = request()->validate([
            'review'=>'required|min:3',
            'rating'=>'required|min:1|max:5|integer'
        ]);
        $book->reviews()->create($data);

        return redirect()->route('books.show',$book);
    }
}
