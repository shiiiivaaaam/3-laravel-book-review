<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'review','rating'
    ];

    public function book(){
        return $this->belongsTo(Book::class,'book_id','id');
    }

    protected static function booted(){

        static::saved(function(Review $review){
            cache()->forget('book'.$review->book_id);
        });

        static::deleted(function(Review $review){
            cache()->forget('book'.$review->book_id);
        });
    }
}
