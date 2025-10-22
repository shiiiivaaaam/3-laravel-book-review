@extends('layout.app')

@section('content')

<h1 class='mb-10 text-2xl'>Add review for {{$book->title}}</h1>

<form action="{{route('books.reviews.store',$book)}}" method="POST">
    @csrf
    <label for="review">Write your review..</label>
    <textarea class="input mb-3" name='review' id='review' required></textarea>
    <label for="rating">Give a rating</label>
    <select class='input mb-3' name="rating" id="rating">
        <option value="">Select A Rating</option>
        @for($i=1;$i<=5;$i++)
            <option value="{{$i}}">{{$i}}</option>
        @endfor
    </select>
    <button class='btn'>Add</button>

</form>



@endsection
