@extends('layouts.app')
@include('navbar')
@include('footer')
@section('css')
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection
@section('title', $user->id . 'のフォロー中')
@section('content')
<div class="container">
@include('user.user')
@include('user.tabs', ['hasReviews' => false, 'hasLikes' => false])

    <div class="row justify-content-center">
        @foreach($followings as $person)
        @include('user.person')
        @endforeach
    </div>

    </div>
@endsection