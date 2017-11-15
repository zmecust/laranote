@extends('app')
@section('content')
    <div class="row">
        <div style="position: absolute; background-color: #00a8c6; height:100vh; width: 70vh; overflow:scroll">
            <p>
                ...
            </p>
        </div>

        <div style="position: absolute; height: 100vh; left: 70vh; width: 132vh; overflow:scroll;">
            <div id="doc-content" class="markdown-body">
                <textarea style="display:none;">
                    {{ $note->body }}
                </textarea>
            </div>
            @include('markdown::decode', ['editors' => ['doc-content']])
            {{--<div>--}}
                {{--{!! $note->body !!}--}}
            {{--</div>--}}
        </div>
    </div>
@stop