@extends('layouts.layout')

@section('content')
<section class="wrapper w-profile">
  <!-- session message -->
  @include('components.messagebox')
  <!-- end session message -->

  <div class="container">
    <!-- modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class=" modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">プロフィール編集</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            {{ Form::open(['url' => route("updateProfile"), 'files' => true , 'id' => 'f-profile-edit', 'class' => 'f-profile-edit']) }}
            <div class="mb-3">
              <label for="icon" class="form-label">アイコン画像</label>
              @if(isset($users->icon))
              <div class="profile-icon-l"><img class="js_preview" src="{{ asset('storage/user_icon/'.$users->icon) }}" alt="{{ $users->icon }}"></div>
              @else
              <div class="profile-icon-l"><img class="js_preview" src="{{ asset('storage/user_icon/default-icon.png') }}" alt="default-icon.png"></div>
              @endif
              @if($errors->has('icon'))
              <ul>
                @foreach($errors->get('icon') as $message)
                <li class="invalid-massage">{{ $message }}</li>
                @endforeach
              </ul>
              @endif
              <div class="icon-previw">
                <img src="" alt="">
              </div>
              {{ Form::file('icon', ['id'=> 'icon', 'class' => 'form-control f-profile-edit_image']) }}
            </div>
            <div class="mb-3">
              <label for="profile" class="form-label">プロフィール</label>
              @if($errors->has('profile'))
              <ul>
                @foreach($errors->get('profile') as $message)
                <li class="invalid-massage">{{ $message }}</li>
                @endforeach
              </ul>
              @endif
              {{ Form::textarea('profile', $users->profile, ['id'=> 'profile', 'class' => 'form-control']) }}
            </div>
            {{ Form::close() }}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
            <button type="submit" form="f-profile-edit" class="btn btn-primary">変更を保存</button>
          </div>
        </div>
      </div>
    </div>

    <!-- detail -->
    <div class="container-md c-profile">
      @if(isset($users->icon))
      <div class="profile-icon-l"><img src="{{ asset('storage/user_icon/'.$users->icon) }}" alt="{{ $users->icon }}"></div>
      @else
      <div class="profile-icon-l"><img src="{{ asset('storage/user_icon/default-icon.png') }}" alt="default-icon.png"></div>
      @endif
      <div class="profile-detail">
        <div class="profile-detail_actions mb-2">
          <span class="text_primary username">{{ $users->user_name }}</span>
          @if(Auth::check() && $users->id === Auth::id() )
          <div class="edit_action">
            <button type="button" class="btn btn-link profile-edit-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">プロフィールを編集</button>
          </div>
          @else
          @isset($following_check[$users->id])
          <div class="follow-action">
            <button type="button" class="btn btn-primary follow-btn"><i class="bi bi-plus-circle" user_id="{{ $users->id }}" data-route="{{ route('storeFollow', $users->id) }}"></i>フォロー</button>
            <button type="button" class="btn btn-danger unfollow-btn is_active" user_id="{{ $users->id }}" data-route="{{ route('deleteFollow', $users->id) }}"><i class="bi bi-dash-circle"></i>フォロー解除</button>
          </div>
          @else
          <div class="follow-action">
            <button type="button" class="btn btn-primary follow-btn is_active" user_id="{{ $users->id }}" data-route="{{ route('storeFollow', $users->id) }}"><i class="bi bi-plus-circle"></i>フォロー</button>
            <button type="button" class="btn btn-danger unfollow-btn" user_id="{{ $users->id }}" data-route="{{ route('deleteFollow', $users->id) }}"><i class="bi bi-dash-circle"></i>フォロー解除</button>
          </div>
          @endisset
          @endif
        </div>
        <ul class="profile-detail_info mb-2">
          <li><span class="info-title">投稿数</span>{{ $posts->count() }}</li>
          <li><span class="info-title">フォロー</span>{{ $users->following->count() }}</li>
          <li><span class="info-title">フォロワー</span>{{ $users->followed->count() }}</li>
        </ul>
        <div class="profile-detail_description">
          <p class="mb-0">{{ $users->profile }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- menu -->
  <div class="container">
    <div class="profile-menu">
      <ul class="profile-tab-list nav nav-tabs">
        <li class="profile-tab-list_inner nav-item" role="presentation">
          <button type="button" class="btn profile-tab nav-link active" id="post-tab" data-bs-toggle="tab" data-bs-target="#post-tab-pane">投稿</button>
        </li>
        <li class="profile-tab-list_inner nav-item" role="presentation">
          <button type="button" class="btn profile-tab nav-link" id="follow-tab" data-bs-toggle="tab" data-bs-target="#follow-tab-pane">フォロー</button>
        </li>
        <li class="profile-tab-list_inner nav-item" role="presentation" role="presentation">
          <button type="button" class="btn profile-tab nav-link" id="like-tab" data-bs-toggle="tab" data-bs-target="#like-tab-pane">いいね</button>
        </li>
      </ul>
    </div>
  </div>

  <div class=" tab-content">
    <div class="profile-post tab-pane show active" id="post-tab-pane" role="tabpanel" aria-labelledby="post-tab" tabindex="0">
      <!-- timeline -->
      @include('components.timeline')
      <!-- end timeline -->
    </div>

    <div class="profile-follow tab-pane" id="follow-tab-pane" role="tabpanel" aria-labelledby="follow-tab" tabindex="0">
      <!-- userlist -->
      @include('components.userlist')
      <!-- end userlist -->
    </div>

    <div class="profile-like tab-pane" id="like-tab-pane" role="tabpanel" aria-labelledby="like-tab" tabindex="0">
      <!-- likelist -->
      <div class="container c-timeline">
        @foreach($likePosts as $post)
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
                    <a class="dropdown-item" href="{{ route('postForm', ['post_id' => $post->id]) }}">投稿内容を編集</a>
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
            <div class="post-body">
              <p class="card-text">{{ $post->post }}</p>
            </div>
            <div class="post-tags">
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
      <!-- end likelist -->
    </div>
  </div>
  <script>
    // upload file preview
    const el = document;
    const previewImage = el.querySelector('.js_preview'),
      uploadFile = el.querySelector('.f-profile-edit_image');

    const filePreview = (e) => {
      const fileReader = new FileReader();
      fileReader.onload = function(e) {
        previewImage.setAttribute('src', e.target.result);
      }
      fileReader.readAsDataURL(e.target.files[0]);
    }
    uploadFile.addEventListener('change', (e) => filePreview(e));
  </script>
</section>
@endsection
