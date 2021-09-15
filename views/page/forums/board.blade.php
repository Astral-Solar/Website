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
        <a href="/forums/boards/{{ $masterBoard->GetID() }}/thread/create">Create a thread</a>
    @endif

    <!-- All the threads -->
    @foreach($masterBoard->GetThreads() as $thread)
        @if ($thread->IsDeleted() and !$me->HasPermission($masterBoard->GetID() . ":forums.thread.delete")) @continue @endif

        <h4><a href="/forums/threads/{{ $thread->GetID() }}">{{ $thread->GetTitle() }}</a></h4>
        @if($thread->IsLocked())
            <b>🔒</b>
        @endif
        @if($thread->IsPinned())
            <b>📌</b>
        @endif
        @if($thread->IsDeleted())
            <b>🗑️</b>
        @endif
        <h5>By {{ $thread->GetCreator()->GetName() }}, {{ $thread->GetCreated() }}</h5>
        @if($thread->GetLastPost())
            <h5>Last Post: {{ $thread->GetLastPost()->GetCreator()->GetName()  }}, {{ $thread->GetLastPost()->GetCreated() }}</h5>
        @endif
        <br>
    @endforeach
@endsection