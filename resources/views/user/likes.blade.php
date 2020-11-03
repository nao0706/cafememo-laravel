@extends('layouts.app')
@include('navbar')
@include('footer')
@section('css')
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection
@section('title', $user->id . 'のいいねした記事')
@section('content')
@include('user.user')
@include('user.tabs', ['hasReviews' => false, 'hasLikes' => true])

    <div class="row justify-content-center">
        @foreach($reviews as $review)
        @include('reviews.card')
        @endforeach
    </div>

  
@endsection