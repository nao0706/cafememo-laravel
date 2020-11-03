@extends('layouts.app')
@include('navbar')
@include('footer')
@section('css')
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection
@section('title', $user->id . 'のフォロー中')
@section('content')
@include('user.user')
@include('user.tabs', ['hasReviews' => false, 'hasLikes' => false])

    <div class="row justify-content-center">
        @foreach($followers as $person)
        @include('user.person')
        @endforeach
    </div>

  
@endsection