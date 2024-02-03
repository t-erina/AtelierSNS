@extends('layouts.layout')

@section('content')
<section class="wrapper w-user_edit">
  <!-- session message -->
  @include('components.messagebox')
  <!-- end session message -->

  <div class="container mb-3">
    <h2>ユーザー情報の設定</h2>
  </div>
  <div class="container c-user_edit">

  @yield('item')
</section>
@endsection
