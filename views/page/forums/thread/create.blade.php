@extends('layouts.app')

@section('title', "Forums")

@section('content')

    <form id="create_thread_form" action="/forums/boards/{{ $masterBoard->GetID() }}/thread/create" method="post" class="ui inverted form">
        <div class="ui inverted top attached dark segment">
            <div class="field">
                <label>Title</label>
                <input type="text" name="title" placeholder="My cool thread!">
            </div>

            <div class="field">
                <label>Content</label>
                <textarea style="display: none" id="content_shadow" name="content"></textarea>
                <div class="ui fitted segment">
                    <div id="content_editor">
                    </div>
                </div>
            </div>

            <div class="ui error message"></div>

        </div>
        <button type="submit" class="fluid ui bottom attached green button" value="Submit">Create Thread</button>
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
                placeholder: 'The body of your cool thread',
                theme: 'snow'  // or 'bubble'
            });

            quill.on('text-change', function(delta, oldDelta, source) {
                $('#content_shadow').val(JSON.stringify(quill.getContents()));
            });
            $('#content_shadow').val(JSON.stringify(quill.getContents()));
        })



        $('#create_thread_form')
            .form({
                on: 'blur',
                fields: {
                    display_name: {
                        identifier  : 'title',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Please provide a title for this thread!'
                            }
                        ]
                    },
                }
            })
    </script>
@endsection