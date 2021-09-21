@extends('layouts.app')

@section('title', 'Home')

@section('header')
  <div class="masthead">
    <div class="ui grid middle aligned" style="height: 100%;">
        <div class="row">
            <div class="column">
                <div class="ui basic text container center aligned segment">
                    <img class="ui centered medium image" src="/public/media/logo.png">
                    <h1 class="ui inverted header">
                        {{ $config->get('App Name') }}
                        <div class="sub header">{{ $config->get('Slogan') }}</div>
                    </h1>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection

@section('content')
    <div class="ui stackable three column centered grid">
        @foreach($config->get('Servers') as $serverIP)
            @php
                $serverData = $cache->get("server-info-" . $serverIP);
            @endphp
            <div class="column">
                <div class="ui inverted attached dark segment">
                    <h4 class="ui header">
                        {{ $serverData['HostName'] }}
                        <div class="sub header">{{ $serverIP }} | {{ $serverData['Map'] }}</div>
                    </h4>

                    <div class="ui inverted indicating progress" data-value="{{ $serverData['Players'] }}" data-total="{{ $serverData['MaxPlayers'] }}" >
                        <div class="bar"></div>
                        <div class="label">Players: {{ $serverData['Players'] }}/{{ $serverData['MaxPlayers'] }}</div>
                    </div>
                </div>
                <a class="ui blue bottom attached button" tabindex="0" href="steam://connect/{{ $serverIP }}">Join</a>
            </div>
        @endforeach
    </div>
@endsection