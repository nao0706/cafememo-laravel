    <ul class="nav nav-tabs nav-justified mt-3">
      <li class="nav-item">
        <a class="nav-link text-muted {{ $hasReviews ? 'active' : '' }}"
           href="{{ route('users.show', [$user->id]) }}">
          記事
        </a>
        
      </li>
      <li class="nav-item">
        <a class="nav-link text-muted {{ $hasLikes ? 'active' : '' }}"
           href="{{ route('users.likes', [$user->id]) }}">
          いいね
        </a>
      </li>
    </ul>