@extends('layouts.app')

@section('title', "Forums")

@section('content')

    <form action="/forums/boards/{{ $masterBoard->GetID() }}/thread/create" method="post">
        <h2>Title</h2>
        <input type="text" name="title" placeholder="My cool thread!">

        <h2>Content</h2>
        <textarea style="display: none" id="content_shadow" name="content"></textarea>
        <div id="content_editor">
        </div>


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
            quill = new Quill('#content_editor', {
                modules: {
                    toolbar: toolbarOptions
                },
                placeholder: 'Please add content to your document!',
                theme: 'snow'  // or 'bubble'
            });

            quill.on('text-change', function(delta, oldDelta, source) {
                $('#content_shadow').val(JSON.stringify(quill.getContents()));
            });
            $('#content_shadow').val(JSON.stringify(quill.getContents()));
        })
    </script>
@endsection