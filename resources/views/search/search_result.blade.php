@extends('layouts.layout')

@section('content')
<div class="wrapper w-search">
  <!-- menu -->
  <div class="container">
    <div class="search-menu">
      <ul class="search-tab-list nav nav-tabs">
        <li class="search-tab-list_inner nav-item" role="presentation">
          <button type="button" class="btn nav-link search-tab active" id="post-tab" data-bs-toggle="tab" data-bs-target="#post-tab-pane">投稿</button>
        </li>
        <li class="search-tab-list_inner nav-item" role="presentation">
          <button type="button" class="btn nav-link search-tab" id="user-tab" data-bs-toggle="tab" data-bs-target="#user-tab-pane">ユーザー</button>
        </li>
      </ul>
    </div>
  </div>

  <!-- search result -->
  <div class="container tab-content">
    <div class="result-post tab-pane show active" id="post-tab-pane" role="tabpanel" aria-labelledby="post-tab" tabindex="0">
      @if($posts->isEmpty())
      <div class="noitem text-center">検索条件に一致する投稿がありません</div>
      @else
      @include('components.timeline')
      @endisset
    </div>

    <div class="result-user tab-pane" id="user-tab-pane" role="tabpanel" aria-labelledby="user-tab" tabindex="0">
      @if($userListUsers->isEmpty())
      <div class="noitem text-center">検索条件に一致するユーザーがいません</div>
      @else
      @include('components.userlist')
      @endisset
    </div>
  </div>
</div>

@endsection
