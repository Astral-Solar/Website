@extends('layouts.app')

@section('title', 'Settings')

@section('content')
  <form action="/settings" id="settings_form" method="post" enctype="multipart/form-data" class="ui inverted form">
    <div class="ui inverted top attached dark segment">
      <div class="field">
        <label>Display Name</label>
        <input type="text" name="display_name" value="{{ $me->GetName() }}" placeholder="Terry">
      </div>

      <div class="field">
        <label>Slug</label>
        <div class="ui labeled input">
          <div class="ui label">
            https://astral.solar/profile/
          </div>
          <input type="text" name="slug" value="{{ $me->GetSlug() }}" placeholder="terry" aria-describedby="slug">
        </div>
      </div>

      <div class="field">
        <label>Background</label>
        <input type="file" name="background" accept="image/png, image/jpeg">
      </div>

      <div class="field">
        <label>Bio</label>
        <textarea style="display: none" id="bio_shadow" name="bio"></textarea>
        <div class="ui fitted segment">
          <div style="height: 200px" id="bio_editor">
          </div>
        </div>
      </div>

      <div class="ui error message"></div>
    </div>
    <button type="submit" class="fluid ui bottom attached blue button" value="Submit">Save Settings</button>
  </form>
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

    $('#settings_form')
      .form({
        on: 'blur',
        fields: {
          display_name: {
            identifier  : 'display_name',
            rules: [
              {
                type   : 'empty',
                prompt : 'Please provide a display name'
              }
            ]
          },
        }
      })
    ;
  </script>
@endsection