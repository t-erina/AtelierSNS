@extends('layouts.layout')

@section('content')
<section class="wrapper">
  <div class="container">
    {{ Form::open(['url' => route("storePost"), 'class' => 'f-post-create', 'files' => true]) }}
    <div class="f-post-create_image_outer">
      <span class="f-post-create-image_icon"><span class="bar vartical"></span><span class="bar horizontal"></span></span>
      <span class="f-post-create-image_text">画像を追加</span>
      {{ Form::file('image', ['class'=>'form-control f-post-create_image']) }}
      @if($errors->has('image'))
      <ul>
        @foreach($errors->get('image') as $message)
        <li class="invalid-massage">{{ $message }}</li>
        @endforeach
      </ul>
      @endif
      <div class="preview">
        <img class="js_preview noimage" src="" alt="プレビュー画像">
      </div>
    </div>
    <div class="f-post-create_post_outer">
      {{ Form::textarea('post', null, ['class' => 'form-control f-post-create_post', 'placeholder' => '投稿内容']) }}
      @if($errors->has('post'))
      <ul>
        @foreach($errors->get('post') as $message)
        <li class="invalid-massage">{{ $message }}</li>
        @endforeach
      </ul>
      @endif
    </div>
    <div class="f-post-create_tag_outer">
      <div class="input-group">
        {{ Form::text('tag', null, ['class' => 'form-control f-post-create_tag','placeholder' => 'タグ（例：イラスト　ハンドメイド　プログラミング）']) }}
      </div>
      @if($errors->has('tag'))
      <ul>
        @foreach($errors->get('tag') as $message)
        <li class="invalid-massage">{{ $message }}</li>
        @endforeach
      </ul>
      @endif
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
      {{ Form::button('投稿する',['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
    {{ Form::close() }}
  </div>

  <script>
    // upload file preview
    const el = document;
    const previewImage = el.querySelector('.js_preview'),
      uploadFile = el.querySelector('.f-post-create_image');

    const filePreview = (e) => {
      const fileReader = new FileReader();
      fileReader.onload = function(e) {
        if (previewImage.classList.contains('noimage')) {
          previewImage.classList.remove('noimage');
        }
        previewImage.setAttribute('src', e.target.result);
      }
      fileReader.readAsDataURL(e.target.files[0]);
    }
    uploadFile.addEventListener('change', (e) => filePreview(e));
  </script>
</section>
@endsection
