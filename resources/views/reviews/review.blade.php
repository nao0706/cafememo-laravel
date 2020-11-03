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
          <form method='POST' action="{{ route('reviews.store') }}" enctype="multipart/form-data">
           @csrf
            <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label>Cafeの名前</label>
                    <input type='text' class='form-control' name='title' required value="{{ $review->title ?? old('title') }}">
                  </div>
                  <div class="form-group">
                  <label>レビュー本文</label>
                    <textarea class='description form-control' name='body' placeholder='本文を入力'>{{ $review->body ?? old('body') }}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="file1">Cafeのサムネイル</label>
                    <input type="file" id="file1" name='image' class="form-control-file">
                  </div>
                </div>
            </div>
           <input type='submit' class='btn btn-primary' value='投稿する'>
          </form>
        </div>
    </div>
    
@endsection