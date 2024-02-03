<div class="sidebar px-3">
  <h1 class="navbar-brand title">
    <a class="" href="{{ route('top') }}">
      <div class="logo">
        <img src="{{ asset('images\laravelsns-icon.png') }}" alt="logo">
        <span class="logo-text">
          {{ config('app.name', 'Atelier') }}
        </span>
      </div>
    </a>
  </h1>
  <div class="sidebar-layout">
    <div class="auth-info">
      <div class="icon">
        <a href="{{ route('profile', ['user_id' => Auth::id()]) }}">
          @if(isset(Auth::user()->icon))
          <div class="profile-icon-l sidebar-icon"><img src="{{ asset('storage/user_icon/'. Auth::user()->icon) }}" alt="{{ Auth::user()->icon }}"></div>
          @else
          <div class="profile-icon-l sidebar-icon"><img src="{{ asset('storage/user_icon/default-icon.png') }}" alt="default-icon.png"></div>
          @endif
        </a>
      </div>
      <div id="nav-btn" class="nav-btn">
        <span class="nav-btn_inner"></span>
      </div>
      <div class="username">
        <span>{{ Auth::user()->user_name }}</span>
      </div>
    </div>
  </div>

  <nav class="navbar p-0">
    <ul id="nav-list" class="nav flex-column sidebar-menu">
      <li>
        {{ Form::open(['url' => route('searchResult'), 'class' => 'f-search']) }}
        <div class="input-group">
          <input type="search" class="form-control" name="keywords" placeholder="アトリエを検索...">
          <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
        </div>
        {{ Form::close() }}
      </li>
      <li class="nav-item">
        <a class="nav-link btn-link" href="{{ route('top') }}">ホーム</a>
      </li>
      <li class="nav-item">
        <a class="nav-link btn-link" href="{{ route('postForm') }}">投稿作成</a>
      </li>
      <li class="nav-item">
        <a class="nav-link btn-link" href="{{ route('profile', ['user_id' => Auth::id()]) }}">プロフィール</a>
      </li>
      <li class="nav-item">
        <a class="nav-link btn-link" href="{{ route('userEditForm') }}">ユーザー情報</a>
      </li>
      <li class="nav-item">
        <a class="nav-link btn-link" href="{{ route('logout') }}">ログアウト</a>
      </li>
    </ul>
  </nav>
</div>
