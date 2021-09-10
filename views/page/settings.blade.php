@extends('layouts.app')

@section('title', 'Settings')
@section('css', '/public/css/index.css')

@section('content')
    <form action="/settings" method="post" enctype="multipart/form-data">
        <h2>Display Name</h2>
        <input type="text" name="display_name" value="{{ $me->GetName() }}" placeholder="my cool display name">

        <h2>Bio</h2>
        <textarea style="display: none" id="bio_shadow" name="bio"></textarea>
        <div id="bio_editor">
        </div>

        <h2>Background</h2>
        <input type="text" name="background" placeholder="https://mycool.image/space.jpg">

        <h2>Slug</h2>
        <input type="text" name="slug" value="{{ $me->GetSlug() }}" placeholder="my cool slug">

        <h2>Submit</h2>
        <button type="submit" value="Submit">Submit</button>
    </form>

    <style>
        .ql-toolbar {
            background-color: white;
        }
        .ql-container {
            background-color: white;
            color: black;
            max-height: 500px;
            overflow: scroll;
        }
    </style>
    <script>
        var quill
        $(document).ready(function(){
            quill = new Quill('#bio_editor', {
                modules: {
                    toolbar: toolbarOptions
                },
                placeholder: 'Please add content to your document!',
                theme: 'snow'  // or 'bubble'
            });

            @if ($me->GetBio())
                data = <?= $me->GetBio() ?>;
                quill.setContents(data);
            @endif

            quill.on('text-change', function(delta, oldDelta, source) {
                $('#bio_shadow').val(JSON.stringify(quill.getContents()));
            });
            $('#bio_shadow').val(JSON.stringify(quill.getContents()));
        })
    </script>
@endsection