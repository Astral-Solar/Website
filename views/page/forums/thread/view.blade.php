@extends('layouts.app')

@section('title', "Forums")

@section('content')
    <!-- Breadcrumb -->
    <!-- The breadcrumb -->
    <div class="ui inverted breadcrumb">
        <a class="section" href="/">Home</a>
        <div class="divider"> / </div>
        <a class="section" href="/forums">Forums</a>
        <div class="divider"> / </div>
        @foreach(array_reverse($thread->GetBoard()->GetBreadCrumb()) as $board)
            <a class="section" href="/forums/boards/{{ $board->GetID() }}">{{ $board->GetName() }}</a>
            <div class="divider"> / </div>
        @endforeach
        <a class="section" href="/forums/boards/{{ $thread->GetBoard()->GetID() }}">{{ $thread->GetBoard()->GetName() }}</a>
        <div class="divider"> / </div>
        <div class="active section">{{ $thread->GetTitle() }}</div>
    </div>

    <!-- This board's children -->
    <div class="ui inverted dark segment">
        <h1 class="ui header">
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
        </h1>
    </div>


    @foreach($thread->GetPosts() as $post)
        @php
            $formatter = new Wookieb\RelativeDate\Formatters\BasicFormatter();
            // You can pick one of calculators. See "calculators" section for details
            $calculator = Wookieb\RelativeDate\Calculators\TimeAgoDateDiffCalculator::full();

            $created = date("Y-m-d H:i:s", $post->GetCreated());
            $createdDate = new \DateTime($created);
        @endphp
        <h2 class="ui top attached inverted dark header" @if($post->GetCreator()->GetBackground()) style="background-image: url('{{ $post->GetCreator()->GetBackground() }}')" @endif>
            <img class="ui avatar image" src="{{ $post->GetCreator()->GetAvatar() }}">

            <div class="content">
                {{ $post->GetCreator()->GetName() }}
                <div class="sub header">{{ $formatter->format($calculator->compute($createdDate)) }}</div>
            </div>
        </h2>
        <div class="ui bottom attached inverted dark segment">
            <div id="post_{{ $post->GetID() }}"></div>

            <script>
                $(document).ready(function() {
                    var quill = new Quill('#post_{{ $post->GetID() }}', {});
                    var data =  {!! $post->GetContent() !!}; // Maybe you can XXS with this?
                    quill.setContents(data);
                    quill.enable(false);
                });
            </script>
        </div>
    @endforeach

    <!-- Reply to this thread -->
    @if($me->exists and !$thread->IsLocked() and !$thread->IsDeleted())
        <form action="/forums/threads/{{ $thread->GetID() }}/reply" method="post" class="ui inverted form">
            <div class="ui inverted top attached dark segment">
                    <textarea style="display: none" id="reply_shadow" name="content"></textarea>
                    <div class="ui fitted segment">
                        <div id="reply_editor">
                        </div>
                    </div>

                    <div class="ui error message"></div>
            </div>
            <button type="submit" class="fluid ui bottom attached green button" value="Submit">Reply</button>
        </form>

        <script>
            $(document).ready(function(){
                var quill = new Quill('#reply_editor', {
                    modules: {
                        toolbar: toolbarOptions
                    },
                    placeholder: 'Write a cool reply to this thread!',
                    theme: 'snow'  // or 'bubble'
                });

                quill.on('text-change', function(delta, oldDelta, source) {
                    $('#reply_shadow').val(JSON.stringify(quill.getContents()));
                });
                $('#reply_shadow').val(JSON.stringify(quill.getContents()));
            })
        </script>
    @endif


    <div class="ui basic fitted segment">
        <div class="ui buttons">
            @if($me->HasPermission($thread->GetID() . ":forums.thread.close"))
                <form action="/forums/threads/{{ $thread->GetID() }}/lock" method="post" class="ui inverted form">
                    <button type="submit" value="Submit" class="compact ui inverted grey button">{{ $thread->IsLocked() ? "Unlock" : "Lock" }}</button>
                </form>
            @endif
            @if($me->HasPermission($thread->GetID() . ":forums.thread.sticky"))
                <form action="/forums/threads/{{ $thread->GetID() }}/pin" method="post" class="ui inverted form">
                    <button type="submit" value="Submit" class="compact ui inverted yellow button">{{ $thread->IsPinned() ? "Unpin" : "Pin" }}</button>
                </form>
            @endif
            @if($me->HasPermission($thread->GetID() . ":forums.thread.delete"))
                <form action="/forums/threads/{{ $thread->GetID() }}/delete" method="post" class="ui inverted form">
                    <button type="submit" value="Submit" class="compact ui inverted red button">{{ $thread->IsDeleted() ? "Restore" : "Delete" }}</button>
                </form>
            @endif
        </div>
    </div>
@endsection