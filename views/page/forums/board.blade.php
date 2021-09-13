@extends('layouts.app')

@section('title', "Forums")

@section('content')
    <!-- The breadcrumb -->
    <a href="/">Home</a> / <a href="/forums">Forums</a> /
    @foreach(array_reverse($masterBoard->GetBreadCrumb()) as $board)
        <a href="/forums/boards/{{ $board->GetID() }}">{{ $board->GetName() }}</a> /
    @endforeach
    <b>{{ $masterBoard->GetName() }}</b>

    <!-- The title -->
    <h1>{{ $masterBoard->GetName() }}</h1>
    <!-- The description -->
    <h2>{{ $masterBoard->GetDescription() }}</h2>

    <hr/>

    <!-- This board's children -->
    @if($masterBoard->GetChildren())
        <h3>All the children</h3>
        @foreach($masterBoard->GetChildren() as $child)
            <a href="/forums/boards/{{ $child->GetID() }}">{{ $child->GetName() }}</a>
        @endforeach
    @endif

    <hr/>

    @if($me->HasPermission($masterBoard->GetID() . ':forums.thread.write'))
        <a href="/forums/boards/{{ $masterBoard->GetID() }}/thread/create">Create a cool thread?</a>
    @endif

    <!-- All the threads -->
@endsection