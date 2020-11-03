@extends('layouts.app')
@include('navbar')
@include('footer')
@section('content')
    <h1 class='pagetitle'>Cafeレビュー投稿ページ</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                
                    <li>{{ $error }}</li>
                    
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row justify-content-center container">
        <div class="col-md-10">
          <form method="post" enctype="multipart/form-data" action="{{ route('reviews.update', ['review' => $review->id]) }}">
            @method('PATCH')
           @include('reviews.form')
           <input type='submit' class='btn btn-primary' value='更新する'>
          </form>
        </div>
    </div>
@endsection