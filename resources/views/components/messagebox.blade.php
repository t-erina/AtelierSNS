  <!-- session message -->
  @if (Session::has('message'))
  <div class="container">
    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
      <span>{{ Session::get('message') }}</span>
      <button type="button" class="btn-close p-3" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
  @endif
