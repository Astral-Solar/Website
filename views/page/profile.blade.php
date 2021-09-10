@extends('layouts.app')

@section('title', $profileOwner->GetName() . "'s Profile")

@section('content')
    <!-- Player info stuff -->
    <div>
        <h1>{{ $me->GetName() }}</h1>
        <a>{{ $me->GetSteamID64() }}</a>
        <img src="{{ $me->GetAvatarURL() }}">
        <!-- This is currently not fully implemented. If you want to use this for now, set it in your settings as a imgurID -->
        <img src="https://i.imgur.com/{{ $me->GetBackground() }}.jpg">
        <!-- you can do `if (!$me->GetBio) {}` if you want to do something if they don't have a bio -->
        <div id="bioViewer">
        </div>
        <script>
            var quill;
            var data;
            $(document).ready(function() {
                quill = new Quill('#bioViewer', {});
                data = <?= $me->GetBio() ?>; // Maybe you can XXS with this?
                quill.setContents(data);
                quill.enable(false);
            });
        </script>
    </div>

@endsection