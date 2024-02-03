@extends('layouts.layout')

@section('content')
<section class="wrapper">
  <!-- session message -->
  @include('components.messagebox')
  <!-- end session message -->
  
  <!-- timeline -->
  @include('components.timeline')
  <!-- end timeline -->
</section>
@endsection
