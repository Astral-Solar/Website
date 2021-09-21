@extends('layouts.app')

@section('title', "Forums")

@section('content')
    <!-- The breadcrumb -->
    <div class="ui inverted breadcrumb">
        <a class="section" href="/">Home</a>
        <div class="divider"> / </div>
        <a class="section" href="/forums">Forums</a>
        <div class="divider"> / </div>
        @foreach(array_reverse($masterBoard->GetBreadCrumb()) as $board)
            <a class="section" href="/forums/boards/{{ $board->GetID() }}">{{ $board->GetName() }}</a>
            <div class="divider"> / </div>
        @endforeach
        <div class="active section">{{ $masterBoard->GetName() }}</div>
    </div>

    <!-- This board's children -->
    <h2 class="ui top attached inverted dark header" @if($masterBoard->GetImage()) style="background-image: url('{{ $masterBoard->GetImage() }}')" @endif>
        {{ $masterBoard->GetName() }}
        <div class="sub header">{{ $masterBoard->GetDescription() }}</div>
    </h2>
    @if($masterBoard->GetChildren())
        <div class="ui bottom attached inverted dark segment">
            <div class="ui relaxed divided inverted list">
                @foreach($masterBoard->GetChildren() as $child)
                    <div class="item">
                        <div class="content">
                            <a class="header" href="/forums/boards/{{ $child->GetID() }}">{{ $child->GetName() }}</a>
                            {{ $child->GetDescription() }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="ui basic fitted segment">
        @if($me->HasPermission($masterBoard->GetID() . ':forums.thread.write'))
            <a class="ui inverted violet button" href="/forums/boards/{{ $masterBoard->GetID() }}/thread/create">Create a thread</a>
        @endif
    </div>

    <!-- All the threads -->
    <h2 class="ui top attached inverted dark header">
        Threads
    </h2>
    <div class="ui bottom attached inverted dark segment">
        <div class="ui middle aligned divided inverted list">
            @foreach($masterBoard->GetThreads() as $thread)
                @if ($thread->IsDeleted() and !$me->HasPermission($masterBoard->GetID() . ":forums.thread.delete")) @continue @endif

                @php
                    $formatter = new Wookieb\RelativeDate\Formatters\BasicFormatter();
                    // You can pick one of calculators. See "calculators" section for details
                    $calculator = Wookieb\RelativeDate\Calculators\TimeAgoDateDiffCalculator::full();

                    $created = date("Y-m-d H:i:s", $thread->GetCreated());
                    $createdDate = new \DateTime($created);
                    if($thread->GetLastPost()) {
                        $lastPost = date("Y-m-d H:i:s", $thread->GetLastPost()->GetCreated());
                        $lastPostDate = new \DateTime($lastPost);
                    }
                @endphp
                <div class="item">
                    <div class="right floated content">
                        @if($thread->GetLastPost())
                            <img class="ui avatar right floated image" src="{{ $thread->GetLastPost()->GetCreator()->GetAvatarURL() }}">
                        @endif
                        <h3 class="ui right floated header">
                            {{ $thread->GetLastPost()->GetCreator()->GetName() }}
                            <div class="sub header">{{ $formatter->format($calculator->compute($lastPostDate)) }}</div>
                        </h3>
                    </div>
                    <img class="ui avatar image" src="{{ $thread->GetCreator()->GetAvatarURL() }}">
                    <div class="content">
                        <h3 class="ui header"><a href="/forums/threads/{{ $thread->GetID() }}">
                                @if($thread->IsLocked())
                                    🔒
                                @endif
                                @if($thread->IsPinned())
                                    📌
                                @endif
                                @if($thread->IsDeleted())
                                    🗑️
                                @endif
                                {{ $thread->GetTitle() }}
                            </a>
                            <div class="sub header">{{ $thread->GetCreator()->GetName() }}, {{ $formatter->format($calculator->compute($createdDate)) }}</div>
                        </h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection