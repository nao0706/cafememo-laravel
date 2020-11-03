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
    </div>
</div>