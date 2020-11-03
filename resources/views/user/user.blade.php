@section('css')
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection
<div class="profile-wrap">
  <div class="container">
  <div class="row">
    <div class="col-md-4 text-center">
      @if ($user->profile_photo)
        <p>
          <img class="round-img" src="{{ asset('storage/user_images/' . $user->profile_photo) }}"/>
        </p>
        @else
          <img class="round-img" src="{{ asset('/images/blank_profile.png') }}"/>
      @endif
    </div>
    <div class="col-md-8">
      <div class="row">
        <h1>{{ $user->name }}</h1>
        
        @if($user->id == Auth::user()->id)

          <a class="btn btn-outline-white common-btn" href="/users/edit">プロフィールを編集</a>
          <a class="btn btn-outline-white common-btn" rel="nofollow" data-method="POST" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
          
         @endif
         @if( Auth::id() !== $user->id )
            <follow-button
              class="ml-auto"
              :initial-is-followed-by='@json($user->isFollowedBy(Auth::user()))'
              :authorized='@json(Auth::check())'
               endpoint="{{ route('users.follow', [$user->id]) }}"
            >
            </follow-button>
          @endif
      </div>
      <div class="row">
        <div class="card-body">
        <div class="card-text">
          <a href="{{ route('users.followings', [$user->id]) }}" class="text-muted">
            {{ $user->count_followings }} フォロー
          </a>
          <a href="{{ route('users.followers', [$user->id]) }}" class="text-muted">
            {{ $user->count_followers }} フォロワー
          </a>
        </div>
      </div>
      </div>
    </div>
  </div>
  </div>
</div>