@extends('layouts.app')

@section('title', $profileOwner->GetName() . "'s Profile")

@section('header')
    <div class="ui basic segment banner" style='background-image: url("{{ $me->GetBackground() }}");'>
      <p></p>
    </div>
@endsection

@section('content')


  <div class="ui stackable grid">

    <div class="five wide column">
      <img class="ui centered medium circular image" src="{{ $profileOwner->GetAvatarURL() }}" style="margin-top: -150px">
      <h1 class="ui inverted center aligned header" style="margin-top: 5px">
        {{ $profileOwner->GetName() }}
        <div class="sub header">{{ $profileOwner->GetSteamID64() }}</div>
      </h1>
    </div>

    <div class="eleven wide column">
      <div class="ui top attached tabular inverted menu">
        <a class="item active" data-tab="first">Profile</a>
        <a class="item" data-tab="second">Forums</a>
        <a class="item" data-tab="third">Servers</a>
      </div>
      <div class="ui bottom attached tab inverted dark segment active" data-tab="first">
        @if($profileOwner->GetBio())
          <div class="card-body" id="bioViewer">
          </div>
        @else
          <p>This user has no bio, encourage them to make one!</p>
        @endif
      </div>
      <div class="ui bottom attached tab inverted dark segment" data-tab="second">
        Second
      </div>
      <div class="ui bottom attached tab inverted dark segment" data-tab="third">
        Third
      </div>
    </div>

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