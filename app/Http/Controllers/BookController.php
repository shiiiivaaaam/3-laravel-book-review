<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = request()->input('title');
        $filter = request()->input('filter');

        $books = Book::when('title',function ($query)use($title){
            return $query->title($title);
        })->withAvg('reviews','rating');

        $books = match($filter){
            'popular_last_month'=>$books->popularLastMonth(),
            'popular_last_6months'=>$books->popularLast6Months(),
            'highest_rated_last_month'=>$books->highestRatedLastMonth(),
            'highest_rated_last_6months'=>$books->highestRatedLast6Months(),
            default=>$books->withcount('reviews')->latest()
        };
        // $books = $books->get();

        $cachekey = 'books:'.$title.':'.$filter ;

        $books = cache()->remember($cachekey,3600,function()use($books){
            return $books->get();
        });

        return view('books.index',['books'=>$books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $cachekey= 'book'.$book->id;

        $book = cache()->remember($cachekey,3600,function()use($book){
            return Book::with([
                'reviews'=>function($query){
                return $query->latest();
            }
            ])->withCount('reviews')->withAvg('reviews','rating')
            ->find($book->id);
        });

        return view('books.show',['book'=>$book]);
    }
    // public function show2 (Book $book){
    //     $reviews = $book->reviews->latest()->get();

    //     return view('books.show',[
    //         'book'=>$book , 'reviews'=>$reviews
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
