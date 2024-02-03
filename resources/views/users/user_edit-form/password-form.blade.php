@extends('users.user_edit')

@section('item')
<div class="mb-3">
  <a href="{{ route('userEditForm') }}" class="icon-link js_backBtn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
    </svg>戻る</a>
</div>

{{ Form::open(['url' => route('updatePassword'), 'id' => 'f-user-edit_password', 'class' => 'f-user-edit_password', 'data-form' => '2']) }}
<label class="form-label">現在のパスワード</label>
@if($errors->has('password'))
<ul>
  @foreach($errors->get('password') as $message)
  <li class="invalid-massage">{{ $message }}</li>
  @endforeach
</ul>
@endif

<div class="mb-3">
  {{ Form::password('password', ['class' => 'form-control']) }}
</div>
<label class="form-label">新しいパスワード</label>
@if($errors->has('newpassword'))
<ul>
  @foreach($errors->get('newpassword') as $message)
  <li class="invalid-massage">{{ $message }}</li>
  @endforeach
</ul>
@endif
<div class="mb-3">
  {{ Form::password('newpassword', ['class' => 'form-control']) }}
</div>
<label class="form-label">新しいパスワード（確認用）</label>
<div class="mb-3">
  {{ Form::password('newpassword_confirmation', ['class' => 'form-control']) }}
</div>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button type="submit" class="btn btn-primary">変更を保存</button>
</div>
{{ Form::close() }}
@endsection
