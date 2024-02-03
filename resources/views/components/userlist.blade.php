<div class="container c-userlist">
  @foreach($userListUsers as $user)
  <div class="card">
    <div class="card-body userlist-header">
      <div class="icon"><a href="{{ route('profile', ['user_id' => $user->id]) }}">
          @if(isset($user->icon))
          <div class="profile-icon"><img src="{{ asset('storage/user_icon/'.$user->icon) }}" alt="{{ $user->icon }}"></div>
          @else
          <div class="profile-icon"><img src="{{ asset('storage/user_icon/default-icon.png') }}" alt="default-icon.png"></div>
          @endif
        </a></div>
      <span class="username">{{ $user->user_name }}</span>
      <div class="profile-detail_actions">
        <div class="actions">
          @if(Auth::check() && $user->id === Auth::id() )
          <div class="edit_action">
          </div>
          @else
          @isset($following_check[$user->id])
          <div class="follow-action">
            <button type="button" class="btn btn-primary btn-sm follow-btn"><i class="bi bi-plus-circle" user_id="{{ $user->id }}" data-route="{{ route('storeFollow', $user->id) }}"></i>フォロー</button>
            <button type="button" class="btn btn-danger btn-sm unfollow-btn is_active" user_id="{{ $user->id }}" data-route="{{ route('deleteFollow', $user->id) }}"><i class="bi bi-dash-circle"></i>フォロー解除</button>
          </div>
          @else
          <div class="follow-action">
            <button type="button" class="btn btn-primary btn-sm follow-btn is_active" user_id="{{ $user->id }}" data-route="{{ route('storeFollow', $user->id) }}"><i class="bi bi-plus-circle"></i>フォロー</button>
            <button type="button" class="btn btn-danger btn-sm unfollow-btn" user_id="{{ $user->id }}" data-route="{{ route('deleteFollow', $user->id) }}"><i class="bi bi-dash-circle"></i>フォロー解除</button>
          </div>
          @endisset
          @endif
        </div>
      </div>
    </div>
    <div class="card-body userlist-body">
      <p class="card-text">{{ $user->profile }}</p>
    </div>
  </div>
  @endforeach

</div>
