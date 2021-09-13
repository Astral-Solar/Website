@extends('layouts.app')

@section('title', "Forums")

@section('content')
    @php
        $allBoards = new Board();
        $allBoards = $allBoards->GetBoardsWithParent();
    @endphp

    <!-- Loop all the master boards -->
    <!-- Would be cool to do something like this: https://forum.facepunch.com/ -->
    @foreach($allBoards as $board)
        <!-- The title -->
        <h1>{{ $board->GetName() }}</h1>
        <!-- The Description -->
        <h2>{{ $board->GetDescription() }}</h2>
        <!-- All the child boards that should be listed inside the master board -->
        Children:
        @foreach($board->GetChildren() as $child)
            <a href="forums/boards/{{ $child->GetID() }}"><h3>{{ $child->GetName() }}</h3></a>
        @endforeach
        <hr/>
    @endforeach
@endsection