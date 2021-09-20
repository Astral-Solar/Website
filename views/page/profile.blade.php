@extends('layouts.app')

@section('title', $profileOwner->GetName() . "'s Profile")

@section('content')
  {{ $profileOwner->GetName() }}
  <b>Steam ID:</b> {{ $profileOwner->GetSteamID64() }}
  Profile
  Forums
  Servers
  @if($profileOwner->GetBio())
    <div class="card-body" id="bioViewer">
    </div>
  @endif


  <div class="ui top attached tabular menu">
    <a class="item active" data-tab="first">Profile</a>
    <a class="item" data-tab="second">Forums</a>
    <a class="item" data-tab="third">Servers</a>
  </div>
  <div class="ui bottom attached tab segment active" data-tab="first">
    First
  </div>
  <div class="ui bottom attached tab segment" data-tab="second">
    Second
  </div>
  <div class="ui bottom attached tab segment" data-tab="third">
    Third
  </div>

  <script>
    var quill;
    var data;
    $(document).ready(function () {
      quill = new Quill('#bioViewer', {});
      data = <?= $profileOwner->GetBio() ?>; // Maybe you can XXS with this?
      quill.setContents(data);
      quill.enable(false);
    });



    $('.menu .item')
      .tab()
    ;
  </script>
@endsection