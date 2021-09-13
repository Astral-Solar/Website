@extends('layouts.app')

@section('title', "Forums")

@section('content')

    <h1>{{ $thread->GetTitle() }}</h1>
    <h2>By: {{ $thread->GetCreator()->GetName() }}</h2>

    <hr/>
    @foreach($thread->GetPosts() as $post)
        <img src="{{ $post->GetCreator()->GetAvatarURL() }}"/>
        <img src="{{ $post->GetCreator()->GetBackground() }}"/>
        <h3>{{ $post->GetCreator()->GetName() }}</h3>
        <div id="post_{{ $post->GetID() }}"></div>

        <script>
            var quill;
            var data;
            $(document).ready(function() {
                quill = new Quill('#post_{{ $post->GetID() }}', {});
                data =  {!! $post->GetContent() !!}; // Maybe you can XXS with this?
                quill.setContents(data);
                quill.enable(false);
            });
        </script>
    @endforeach
@endsection