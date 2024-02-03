@extends('layouts.layout')

@section('content')
<section class="wrapper">
  <!-- session message -->
  @include('components.messagebox')
  <!-- end session message -->

  <!-- post -->
  <div class="container c-timeline">
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
          <p class="card-text">{{ $post->post }}</p>
        </div>
        <div class="post-body_tags">
          @if(!empty($post->tag))
          <?php $tagArray = explode(' ', $post->tag) ?>
          @foreach($tagArray as $tag)
          <a href="#" class="card-link">{{ "#".$tag }}</a>
          @endforeach
          @endif
        </div>
      </div>

      <div class="card-footer post-footer">
        <div class="post-info">
          <p><time>{{ $post->created_at->format('Y-m-d h:i') }}</time></p>
        </div>
        <ul class="post-action-list">
          <li class="post-action-list_inner">
            <button class="repost-btn repost"><i class="bi bi-arrow-repeat"></i></button>
          </li>
          @if(!empty($psot->likes))
          <li class="post-action-list_inner">
            <button class="like-action-btn store-like-btn" post_id="{{ $post->id }}" data-route="{{ route('storeLike', $post->id) }}"><i class="bi bi-suit-heart"></i></button>
            <button class="like-action-btn delete-like-btn is_paused" post_id="{{ $post->id }}" data-route="{{ route('deleteLike', $post->id) }}"><i class="bi bi-suit-heart-fill"></i></button>
          </li>
          @else
          <li class="post-action-list_inner">
            <button type="button" class="like-action-btn store-like-btn is_paused" post_id="{{ $post->id }}" data-route="{{ route('storeLike', $post->id) }}"><i class="bi bi-suit-heart"></i></button>
            <button type="button" class="like-action-btn delete-like-btn" post_id="{{ $post->id }}" data-route="{{ route('deleteLike', $post->id) }}"><i class="bi bi-suit-heart-fill"></i></button>
          </li>
          @endif
        </ul>
      </div>
    </div>
  </div>

  <!-- comment form -->
  <div class="container">
    {{ Form::open(['url' => route('storeComment', $post->id), 'class' => 'f-store-comment']) }}
    <div class="input-group search">
      {{ Form::text('comment', null ,['class' => 'form-control']) }}
      <button class="btn btn-primary" type="submit"><i class="bi bi-send"></i></button>
    </div>
    @if($errors->has('comment'))
    <ul>
      @foreach($errors->get('comment') as $message)
      <li class="invalid-massage">{{ $message }}</li>
      @endforeach
    </ul>
    @endif
    {{ Form::close() }}
  </div>

  <!-- comment list -->
  <div class="container c-comment">
    <ul class="comment-list">
      @foreach($post->comments as $comment)
      <li class="card comment-list_inner">
        <div class="card-body post-header">
          <div class="icon">
            <a href="{{ route('profile', ['user_id' => $post->user_id]) }}">
              @if(isset($comment->user->icon))
              <div class="profile-icon"><img src="{{ asset('storage/user_icon/'.$comment->user->icon) }}" alt="{{ $comment->user->icon }}"></div>
              @else
              <div class="profile-icon"><img src="{{ asset('storage/user_icon/default-icon.png') }}" alt="default-icon.png"></div>
              @endif
            </a>
          </div>
          <span class="username">{{ $comment->user->user_name }}</span>
          <div class="actions">
            @if(Auth::check() && $comment->user_id === Auth::id() )
            <div class="post-edit-action">
              <button class="btn btn-link post-edit-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>
              <ul class="dropdown-menu post-edit-list">
                <li class="dropdown-item">
                  <button type="button" class="dropdown-item comment-edit-btn" data-btnid="{{ $comment->id }}">コメントを編集</button>
                </li>
                <li class="dropdown-item">
                  <form action="{{ route('deleteComment', ['comment_id' => $comment->id]) }}" method="post" class="f-delete-post">
                    <button type="submit" class="dropdown-item">コメントを削除する</button>
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
        <div class="card-body comment" data-contentid="{{ $comment->id }}">
          <p class="card-text comment-body">{!! nl2br(htmlspecialchars ($comment->comment)) !!}</p>
          {{ Form::open(['url' => route('updateComment', $comment->id), 'class' => 'f-comment-update']) }}
          <div class="mb-3">
            {{ Form::textarea('comment', $comment->comment, ['class'=>'form-control f-comment-update_comment']) }}
          </div>
          <div class="d-grid gap-2 d d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-secondary comment-update-form_close-btn" data-closebtnid="{{ $comment->id }}">キャンセル</button>
            {{ Form::button('変更を保存',['type' => 'submit', 'class' => 'btn btn-primary comment-update-form_submit-btn']) }}
          </div>
          {{ Form::close() }}
        </div>

        <div class="card-footer post-footer">
          <div class="post-info">
            <p><time>{{ $comment->created_at->format('Y-m-d h:i') }}</time></p>
          </div>
        </div>
      </li>
      @endforeach
    </ul>
  </div>
  <script src="{{ asset('js/comment-form.js') }}"></script>
</section>
@endsection
