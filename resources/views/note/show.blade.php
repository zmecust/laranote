@extends('app')
@section('content')
    <div id="container">
        <div class="left">
            <sidebar></sidebar>
        </div>

        <div class="right">
            <div class="col-md-12 text-right note-show">
                <button type="submit" class="btn">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    编辑
                </button>
                <button type="submit" class="btn btn-danger">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    删除 
                </button>
            </div>
            <div id="doc-content">
                <textarea style="display:none">
                    {{ trim($note->body) }}
                </textarea>
            </div>
            @include('markdown::decode', ['editors' => ['doc-content']])    

            <!-- <div class="markdown-body editormd-html-preview">
                {!! $note->body !!}
            </div> -->
        </div>
    </div>
@stop