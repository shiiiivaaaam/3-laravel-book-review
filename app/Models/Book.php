<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;



    public function reviews(){
        return $this->hasMany(Review::class,'book_id','id');
    }
    public function scopeTitle(Builder $query,$search):Builder{
        return $query->where('title', 'like','%'.$search.'%');
    }
    public function scopePopular($query){
        return $query->withcount('reviews')->orderBy('reviews_count','desc');
    }
    public function scopeHighestRated($query){
        return $query->withAvg('reviews','rating')->orderBy('reviews_avg_rating','desc');
    }
    public function scopePopular2($query,$from=null,$to=null){
        return $query->withcount(['reviews'=>function($q)use($from,$to){
            if($from && !$to){
                $q->where('created_at','>=',$from);
            }else if($to && !$from){
                $q->where('created_at','<=',$to);
            }else if($to && $from) {
                $q->whereBetween('created_at',[$from , $to]);
            }
        }])->orderBy('reviews_count','desc');
    }
    private function DateRangeFilter($query , $from=null , $to=null){
        if($from && !$to){
                $query->where('created_at','>=',$from);
            }else if($to && !$from){
                $query->where('created_at','<=',$to);
            }else if($to && $from) {
                $query->whereBetween('created_at',[$from , $to]);
            }
    }
    public function scopeHighestRated2($query , $from=null , $to= null){

        return $query->withAvg([
            'reviews'=> function($q)use($from,$to){
                $this->DateRangeFilter($q,$from,$to);
            }
        ]
        ,'rating')

    ->orderBy('reviews_avg_rating','desc');
    }

    public function scopePopularLastMonth($query){
        return $query->popular(now()->subMonth(),now())
        ->highestRated(now()->subMonth(),now())
        ->having('reviews_count','>=',5)->limit(10);

    }
    public function scopeHighestRatedLastMonth($query){
        return $query
        ->highestRated(now()->subMonth(),now())
        ->popular(now()->subMonth(),now())
        ->having('reviews_count','>=',5)->limit(10);

    }
    public function scopePopularLast6Months($query){
        return $query->popular(now()->subMonths(6),now())
        ->highestRated(now()->subMonths(6),now())
        ->having('reviews_count','>=',5)->limit(10);

    }
    public function scopeHighestRatedLast6Months($query){
        return $query
        ->highestRated(now()->subMonths(6),now())
        ->popular(now()->subMonths(6),now())
        ->having('reviews_count','>=',5)->limit(10);

    }

    protected static function booted(){

        static ::saved(function(Book $book){
            cache()->forget('book'.$book->id);
        });

        static :: deleted(function(Book $book){
            cache()->forget('book'.$book->id);
        });
    }



}
