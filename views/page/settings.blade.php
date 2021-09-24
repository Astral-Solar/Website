@extends('layouts.app')

@section('title', 'Settings')

@section('content')
  <div class="ui stackable two column grid">
    <div class="column">
      <form action="/settings" id="settings_form" method="post" enctype="multipart/form-data" class="ui inverted form">
        <h2 class="ui top attached inverted dark header">
          Profile Settings
        </h2>
        <div class="ui inverted attached dark segment">
          <div class="field">
            <label>Display Name</label>
            <input type="text" name="display_name" value="{{ $me->GetName() }}" placeholder="Terry">
          </div>

          <div class="field">
            <label>Slug</label>
            <div class="ui labeled input">
              <div class="ui label">
                astral.solar/profile/
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

        <button type="submit" class="fluid ui bottom attached blue button" style="margin-bottom: 20px;" value="Submit">Save Settings</button>
      </form>
    </div>


    <div class="column">
      <h2 class="ui top attached inverted dark header">
        Discord Account
      </h2>
      @if($me->GetLinkedDiscord())
        <div class="ui inverted bottom attached dark segment">
          <img class="ui centered medium circular image" src="/public/storage/discord/{{ $me->GetLinkedDiscord()->discord_id }}.jpg">
          <h2 class="ui center aligned header">
            {{ $me->GetLinkedDiscord()->name }}
            <div class="sub header">{{ $me->GetLinkedDiscord()->discord_id }}</div>
          </h2>
        </div>
      @else
        <div class="ui inverted attached dark segment">
          <p>
            You can link your Discord account here to gain full access to the main Discord. Once you have linked your account, you will automatically receive your Discord roles.
          </p>
        </div>
        <a href="/discord/link" class="fluid ui bottom attached purple button">Link Discord</a>
      @endif
    </div>
  </div>


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