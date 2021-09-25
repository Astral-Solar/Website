@extends('layouts.app')

@section('title', 'Members')

@section('content')
    @php
        if (isset($_GET['s']) ?? !($_GET['s'] == "")) {
            $users = $me->FindAllByWord($_GET['s']);
        } else {
            $users = $me->GetAll();
        }

        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
        $totalPages = ceil(count($users)/12); // We show 12 people per page, 4*3
    @endphp

    <div class="ui horizontally fitted basic segment">
        <form method="get" class="ui inverted form">
            <div class="ui fluid action input">
                <input name="s" type="text" placeholder="Search...">
                <button type="submit" class="ui button" value="Submit">Search</button>
            </div>
        </form>
    </div>

    <div class="ui stackable four column grid">
        @foreach($users as $key => $user)
            @php
                if($key < (($currentPage - 1) * 12)) continue; // They're on the previous page
                if($key >= (($currentPage) * 12)) continue; // They're on the next page
            @endphp
            <div class="column">
                <div class="ui inverted top attached dark segment banner" style='min-height: 120px; background-image: url("{{ $user->GetBackground() }}");'>
                </div>
                <div class="ui inverted attached dark segment">
                    <img class="ui centered small circular image" src="{{ $user->GetAvatar() }}" style="margin-top: -100px">
                    <h2 class="ui center aligned header" style="margin-top: 10px;">
                        {{ $user->GetName() }}
                        <div class="sub header">{{ $user->GetSteamID64() }}</div>
                    </h2>
                </div>
                <a class="ui orange bottom attached button" tabindex="0" href="/profile/{{ $user->GetSteamID64() }}">Profile</a>
            </div>
        @endforeach
    </div>

    @if($totalPages > 1)
        <div class="ui icon buttons" style="margin-top: 20px;">
            @if(!($currentPage == 1))
                <a class="ui button" href="?{{ isset($_GET['s']) ? 's=' . $_GET['s'] : "" }}&page={{ $currentPage - 1 }}">
                    <i class="angle left icon"></i>
                </a>
            @endif
            <a class="ui button">
                {{ $currentPage }}/{{ $totalPages }}
            </a>
            @if(!($currentPage == $totalPages))
                <a class="ui button" href="?{{ isset($_GET['s']) ? 's=' . $_GET['s'] : "" }}&page={{ $currentPage + 1 }}">
                    <i class="angle right icon"></i>
                </a>
            @endif
        </div>
    @endif
@endsection