<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
         Book::factory()->count(33)->create()->each(function($book){
            $numReviews = random_int(5,30);
            Review::factory()->count($numReviews)
            ->avg()
            ->for($book)
            ->state(function(array $attributes)use($book){
                $review_created_at = fake()->dateTimeBetween($book->created_at,'now');
                return [
                    'created_at'=>$review_created_at,
                    'updated_at'=>fake()->dateTimeBetween($review_created_at,'now')
                ];
            })
            ->create();
         });

         Book::factory()->count(33)->create()->each(function($book){
            $numReviews = random_int(5,30);
            Review::factory()->count($numReviews)
            ->avg()
            ->for($book)
            ->state(function(array $attributes)use($book){
                $review_created_at = fake()->dateTimeBetween($book->created_at,'now');
                return [
                    'created_at'=>$review_created_at,
                    'updated_at'=>fake()->dateTimeBetween($review_created_at,'now')
                ];
            })
            ->create();
         });

         Book::factory()->count(34)->create()->each(function($book){
            $numReviews = random_int(5,30);
            Review::factory()->count($numReviews)
            ->avg()
            ->for($book)
            ->state(function(array $attributes)use($book){
                $review_created_at = fake()->dateTimeBetween($book->created_at,'now');
                return [
                    'created_at'=>$review_created_at,
                    'updated_at'=>fake()->dateTimeBetween($review_created_at,'now')
                ];
            })
            ->create();
         });



        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
