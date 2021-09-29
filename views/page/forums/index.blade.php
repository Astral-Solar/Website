@extends('layouts.app')

@section('title', "Forums")

@section('content')
    @php
        $masterBoard = new Board();
        $allBoards = $masterBoard->GetBoardsWithParent();
    @endphp

    <!-- Loop all the master boards -->
    <!-- Would be cool to do something like this: https://forum.facepunch.com/ -->
    <div class="ui stackable grid">
        <div class="twelve wide column">
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
        </div>
        <div class="four wide column">
            <h2 class="ui top attached inverted dark header">
                Recent Activity
            </h2>
            <div class="ui attached inverted dark segment" style="margin-bottom: 20px;">
                <div class="ui middle aligned divided inverted list">
                    @foreach($masterBoard->GetRecentActivity() as $post)
                        @php
                            $formatter = new Wookieb\RelativeDate\Formatters\BasicFormatter();
                            // You can pick one of calculators. See "calculators" section for details
                            $calculator = Wookieb\RelativeDate\Calculators\TimeAgoDateDiffCalculator::full();

                            $postD = date("Y-m-d H:i:s", $post->GetCreated());
                            $postDate = new \DateTime($postD);
                        @endphp
                        <div class="item">
                            <img class="ui avatar left floated image" src="{{ $post->GetCreator()->GetAvatar() }}">
                            <h3 class="ui header">
                                {{ $post->GetThread()->GetTitle() }}
                                <div class="sub header">{{ $post->GetCreator()->GetName() }} - {{ $formatter->format($calculator->compute($postDate)) }}</div>
                            </h3>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection