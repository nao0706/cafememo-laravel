<div class="col-md-4">
            <div class="card mb50">
                
                <div class="card-header align-items-center d-flex">
                  <a class="no-text-decoration" href="/users/{{ $review->user->id }}">
                    @if ($review->user->profile_photo)
                        <img class="review-profile-icon round-img" src="{{ asset('storage/user_images/' . $review->user->profile_photo) }}"/>
                    @else
                        <img class="review-profile-icon round-img" src="{{ asset('/images/blank_profile.png') }}"/>
                    @endif
                  </a>
                  <a class="black-color no-text-decoration" title="{{ $review->user->name }}" href="/users/{{ $review->user->id }}">
                    <strong>{{ $review->user->name }}</strong>
                  </a>
                  {{ $review->created_at->format('Y/m/d H:i') }} 
                  
                  @if( Auth::id() === $review->user_id )
                    <!-- dropdown -->
                    <div class="ml-auto card-text">
                      <div class="dropdown">
                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <button type="button" class="btn btn-link text-muted m-0 p-2">
                            <i class="fas fa-ellipsis-v"></i>
                          </button>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="{{ route("reviews.edit", ['review' => $review]) }}">
                            <i class="fas fa-pen mr-1"></i>記事を更新する
                          </a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $review->id }}">
                            <i class="fas fa-trash-alt mr-1" href="route('reviews.destroy')"></i>記事を削除する
                          </a>
                        </div>
                      </div>
                    </div>
                    <!-- dropdown -->
            
                    <!-- modal -->
                    <div id="modal-delete-{{ $review->id }}" class="modal fade" tabindex="-1" role="dialog">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="POST" action="{{route('reviews.destroy', ['review' => $review]) }}">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                              {{ $review->title }}を削除します。よろしいですか？
                            </div>
                            <div class="modal-footer justify-content-between">
                              <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                              <button type="submit" class="btn btn-danger">削除する</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- modal -->
                  @endif
                </div>

                <div class="card-body">
                    
                    @if(!empty($review->image))
                      <div class='image-wrapper'><img class='review-image' src="{{ asset('storage/images/'.$review->image) }}"></div>
                    @else
                      <div class='image-wrapper'><img class='review-image' src="{{ asset('images/dummy.png') }}"></div>
                    @endif
                    
                    <h3 class='h3 review-title'>{{$review->title}}</h3>
                    <p class='description'>
                        {{$review->body}}
                    </p>
                
                    <div class="card-text">
                      <review-like
                        :initial-is-liked-by='@json($review->isLikedBy(Auth::user()))'
                        :initial-count-likes='@json($review->count_likes)'
                        :authorized='@json(Auth::check())'
                        endpoint="{{ route('reviews.like', ['review' => $review]) }}"
                      >
                      </review-like>
                    </div>
                    <a href="{{ route('reviews.show', ['review' => $review->id ]) }}" class='btn btn-info detail-btn'>詳細を読む</a>
 
                </div>
            </div>
            
        </div>