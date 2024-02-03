@extends('users.user_edit')

@section('item')
<div class=" list-group">
  <a href="{{ route('usernameUpdateForm') }}" class="list-group-item list-group-item-action">ユーザー名の変更</a>
  <a href="{{ route('emailUpdateForm') }}" class="list-group-item list-group-item-action">メールアドレスの変更</a>
  <a href="{{ route('passwordUpdateForm') }}" class="list-group-item list-group-item-action">パスワードの変更</a>
</div>
@endsection
