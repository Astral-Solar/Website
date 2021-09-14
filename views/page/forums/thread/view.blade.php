@extends('layouts.app')

@section('title', "Forums")

@section('content')
    <!-- Breadcrumb -->
    <a href="/">Home</a> / <a href="/forums">Forums</a> /
    @foreach(array_reverse($thread->GetBoard()->GetBreadCrumb()) as $board)
        <a href="/forums/boards/{{ $board->GetID() }}">{{ $board->GetName() }}</a> /
    @endforeach
    <a href="/forums/boards/{{ $thread->GetBoard()->GetID() }}">{{ $thread->GetBoard()->GetName() }}</a> /
    <b>{{ $thread->GetTitle() }}</b>

    <!-- Thread info -->
    <h1>{{ $thread->GetTitle() }}</h1>
    <h2>By: {{ $thread->GetCreator()->GetName() }}</h2>

    <hr/>
    @foreach($thread->GetPosts() as $post)
        <img src="{{ $post->GetCreator()->GetAvatarURL() }}"/>
        <img src="{{ $post->GetCreator()->GetBackground() }}"/>
        <h3>{{ $post->GetCreator()->GetName() }} - {{ $post->GetCreated() }}</h3>
        <div id="post_{{ $post->GetID() }}"></div>

        <script>
            $(document).ready(function() {
                var quill = new Quill('#post_{{ $post->GetID() }}', {});
                var data =  {!! $post->GetContent() !!}; // Maybe you can XXS with this?
                quill.setContents(data);
                quill.enable(false);
            });
        </script>
    @endforeach

    <hr/>
    <!-- Reply to this thread -->
    @if($me->exists and !$thread->IsLocked())
        <form action="/forums/threads/{{ $thread->GetID() }}/reply" method="post">
            <textarea style="display: none" id="reply_shadow" name="content"></textarea>
            <div id="reply_editor">
            </div>

            <h2>Submit</h2>
            <button type="submit" value="Submit">Submit</button>
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
@endsection