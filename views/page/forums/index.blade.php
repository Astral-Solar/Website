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
        @if(!$me->HasPermission($board->GetID() . ':forums.thread.%'))
            @continue
        @endif
        <h2 class="ui top attached inverted dark header" @if($board->GetImage()) style="background-image: url('{{ $board->GetImage() }}')" @endif>
            {{ $board->GetName() }}
            <div class="sub header">{{ $board->GetDescription() }}</div>
        </h2>
        <div class="ui attached inverted dark segment" style="margin-bottom: 20px;">
            <div class="ui relaxed divided inverted list">
                @foreach($board->GetChildren() as $child)
                    <div class="item">
                        <div class="content">
                            <a class="header" href="forums/boards/{{ $child->GetID() }}">{{ $child->GetName() }}</a>
                            {{ $child->GetDescription() }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @endforeach
@endsection