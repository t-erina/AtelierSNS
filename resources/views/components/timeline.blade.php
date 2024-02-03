    <div class="container c-timeline">
      @foreach($posts as $post)
      <div class="post card">
        <div class="card-body post-header">
          <div class="icon"><a href="{{ route('profile', ['user_id' => $post->user_id]) }}">
              @if(isset($post->user->icon))
              <div class="profile-icon"><img src="{{ asset('storage/user_icon/'.$post->user->icon) }}" alt="{{ $post->user->icon }}"></div>
              @else
              <div class="profile-icon"><img src="{{ asset('storage/user_icon/default-icon.png') }}" alt="default-icon.png"></div>
              @endif
            </a></div>
          <span class="username">{{ $post->user->user_name}}</span>
          <div class="actions">
            @if(Auth::check() && $post->user_id === Auth::id() )
            <div class="post-edit-action">
              <button class="btn btn-link post-edit-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>
              <ul class="dropdown-menu post-edit-list">
                <li class="dropdown-item">
                  <a class="dropdown-item" href="{{ route('postUpdateForm', ['post_id' => $post->id]) }}">投稿内容を編集</a>
                </li>
                <li class="dropdown-item">
                  <form action="{{ route('deletePost', ['post_id' => $post->id]) }}" method="post" class="f-delete-post">
                    <button type="submit" class="dropdown-item">投稿を削除する</button>
                    @csrf
                  </form>
                </li>
              </ul>
            </div>
            @else
            @isset($following_check[$post->user_id])
            <div class="follow-action">
              <button type="button" class="btn btn-primary btn_sm follow-btn"><i class="bi bi-plus-circle" user_id="{{ $post->user_id }}" data-route="{{ route('storeFollow', $post->user_id) }}"></i>フォロー</button>
              <button type="button" class="btn btn-danger btn-sm unfollow-btn is_active" user_id="{{ $post->user_id }}" data-route="{{ route('deleteFollow', $post->user_id) }}"><i class="bi bi-dash-circle"></i>フォロー解除</button>
            </div>
            @else
            <div class="follow-action">
              <button type="button" class="btn btn-primary btn-sm follow-btn is_active" user_id="{{ $post->user_id }}" data-route="{{ route('storeFollow', $post->user_id) }}"><i class="bi bi-plus-circle"></i>フォロー</button>
              <button type="button" class="btn btn-danger btn-sm unfollow-btn" user_id="{{ $post->user_id }}" data-route="{{ route('deleteFollow', $post->user_id) }}"><i class="bi bi-dash-circle"></i>フォロー解除</button>
            </div>
            @endisset
            @endif
          </div>
        </div>

        <div class="card-body post-body">
          @if(!empty($post->images->first()))
          <div class="post-image">
            <img class="card-img-top" src="{{ asset('storage/post_images/'.$post->images->first()->file_name) }}" alt="{{$post->images->first()->file_name}}">
          </div>
          @endif
          <div class="post-body_post">
            <p class="card-text">{!! nl2br(htmlspecialchars ($post->post)) !!}</p>
          </div>

          @if(!empty($post->tag))
          <?php $tagArray = explode(' ', $post->tag) ?>
          <div class="post-body_tags">
            @foreach($tagArray as $tag)<a href="#" class="card-link">{{"#".$tag}}</a>@endforeach
          </div>
          @endif
        </div>

        <div class="card-footer post-footer">
          <div class="post-info">
            <p><time>{{ $post->created_at->format('Y-m-d h:i') }}</time></p>
          </div>
          <ul class="post-action-list">
            <li class="post-action-list_inner">
              <a href="{{ route('postDetail', ['post_id' => $post->id]) }}" class="comment-btn"><i class="bi bi-chat-dots"></i></a>
            </li>
            <li class="post-action-list_inner">
              <button class="repost-btn repost"><i class="bi bi-arrow-repeat"></i></button>
            </li>
            @isset($likePost_check[$post->id])
            <li class="post-action-list_inner">
              <button class="like-action-btn store-like-btn" post_id="{{ $post->id }}" data-route="{{ route('storeLike', $post->id) }}"><i class="bi bi-suit-heart"></i></button>
              <button class="like-action-btn delete-like-btn is_paused" post_id="{{ $post->id }}" data-route="{{ route('deleteLike', $post->id) }}"><i class="bi bi-suit-heart-fill"></i></button>
            </li>
            @else
            <li class="post-action-list_inner">
              <button type="button" class="like-action-btn store-like-btn is_paused" post_id="{{ $post->id }}" data-route="{{ route('storeLike', $post->id) }}"><i class="bi bi-suit-heart"></i></button>
              <button type="button" class="like-action-btn delete-like-btn" post_id="{{ $post->id }}" data-route="{{ route('deleteLike', $post->id) }}"><i class="bi bi-suit-heart-fill"></i></button>
            </li>
            @endisset
          </ul>
        </div>
      </div>
      @endforeach
    </div>
