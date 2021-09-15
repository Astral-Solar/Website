@extends('layouts.app')

@section('title', 'Settings')
@section('css', '/public/css/settings.css')

@section('header')
  @include('partials.header')
@endsection

@section('content')
  <main class="container">
    <div class="card m-5">
      <div class="card-body">
        <form action="/settings" class="m-3" method="post" enctype="multipart/form-data">
          <h4>Display Name</h4>
          <input type="text" class="form-control mb-3" name="display_name" value="{{ $me->GetName() }}" placeholder="my cool display name">

          <h4>Slug</h4>
          <div class="input-group mb-3">
            <span class="input-group-text" id="slug">https://astral.solar/profile/</span>
            <input type="text" class="form-control" name="slug" value="{{ $me->GetSlug() }}" placeholder="my cool slug" aria-describedby="slug">
          </div>

          <h4>Background</h4>
          <div class="input-group mb-3">
            <input type="file" name="background" accept="image/png, image/jpeg">
          </div>

          <h4>Bio</h4>
          <textarea style="display: none" id="bio_shadow" name="bio"></textarea>
          <div class="mb-3" style="height: 200px" id="bio_editor">
          </div>

          <button type="submit" class="btn btn-success" value="Submit">Save Settings</button>
        </form>
      </div>
    </div>
  </main>
  <script>
    var quill
    $(document).ready(function () {
      quill = new Quill('#bio_editor', {
        modules: {
          toolbar: toolbarOptions
        },
        placeholder: 'Welcome to my profile, let\'s hang out!',
        theme: 'snow'  // or 'bubble'
      });

      @if ($me->GetBio())
          data = <?= $me->GetBio() ?>;
          quill.setContents(data);
      @endif

      quill.on('text-change', function (delta, oldDelta, source) {
        $('#bio_shadow').val(JSON.stringify(quill.getContents()));
      });
      $('#bio_shadow').val(JSON.stringify(quill.getContents()));
    })
  </script>
@endsection