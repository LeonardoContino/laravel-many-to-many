@if (session('msg'))
  <div class="my-3 alert alert-{{ session('type') ?? 'info' }}">
    {{ session('msg') }}
  </div>
@endif