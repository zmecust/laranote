@extends('app')
@section('content')
    <div style="width: 96%; margin-left: 2%">
        <form class="form-horizontal" role="form" method="PATCH" action="/notes/{{ $note->id }}">  
            {!! csrf_field() !!}
            
            @include('note.form') 
        </form>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#category').select2({
                    placeholder : '笔记归类',
                    maximumSelectionLength: 1
                });
                $('#tag').select2({
                    placeholder : '选择/创建标签',
                    tags : true
                });
            });
        </script>
    </div>
@stop