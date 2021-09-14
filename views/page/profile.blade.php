@extends('layouts.app')

@section('title', $profileOwner->GetName() . "'s Profile")
@section('css', '/public/css/profile.css')

@section('header')
  @include('partials.header')
@endsection

@section('content')
  <main class="container">
    <div class="row">
      <div class="col-lg-3 mb-4">
        <div class="card">
          <!-- This is currently not fully implemented. If you want to use this for now, set it in your settings as a imgurID -->
          <div class="card-body" style="background-image: url('https://i.imgur.com/{{ $me->GetBackground() }}.jpg')">
            <div class="profile-header">
              <img class="d-block mx-auto rounded-circle" src="{{ $profileOwner->GetAvatarURL() }}">
              <h4 class="text-center mt-3">
                {{ $profileOwner->GetName() }}
              </h4>
            </div>
            <hr>
            <div class="card-text">
              <b>Steam ID:</b> {{ $profileOwner->GetSteamID64() }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 mb-4">
        <div class="card">
          <div class="card-body">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                  type="button">Profile</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="forums-tab" data-bs-toggle="tab" data-bs-target="#forums"
                  type="button">Forums</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="servers-tab" data-bs-toggle="tab" data-bs-target="#servers"
                  type="button">Servers</button>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="profile">
                @if($profileOwner->GetBio())
                <h3 class="card-text mt-3">Bio</h3>
                <div class="card">
                  <div class="card-body" id="bioViewer">
                  </div>
                </div>
                @endif
              </div>
              <div class="tab-pane fade" id="forums">
                @foreach($profileOwner->GetRecentForumPosts() as $post)
                  <a href="/forums/threads/{{ $post->GetThread()->GetID() }}"><h5>{{ $post->GetThread()->GetTitle() }}</h5></a>
                  <h6>{{ $post->GetCreated() }}</h6>
                  <div id="post_{{ $post->GetID() }}"></div>

                  <script>
                    $(document).ready(function() {
                      var quill = new Quill('#post_{{ $post->GetID() }}', {});
                      var data =  {!! $post->GetContent() !!}; // Maybe you can XXS with this?
                      quill.setContents(data);
                      quill.enable(false);
                    });
                  </script>
                @endforeach
              </div>
              <div class="tab-pane fade" id="servers">...</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script>
    var quill;
    var data;
    $(document).ready(function () {
      quill = new Quill('#bioViewer', {});
      data = <?= $profileOwner->GetBio() ?>; // Maybe you can XXS with this?
      quill.setContents(data);
      quill.enable(false);
    });
  </script>
@endsection