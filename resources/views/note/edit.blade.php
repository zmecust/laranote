@extends('app')
@section('content')
    <div style="width: 96%; margin-left: 2%">
        <form class="form-horizontal" role="form" method="POST" action="/notes/{{ $note->id }}">
            {{ method_field('PATCH') }}
            {!! csrf_field() !!}

            <div class="form-group">
                <div class="row note-create">
                    <div class="col-md-3 text-left">
                        <select class="form-control" name="category" id="category" style="width: 100%" multiple="multiple">
                            @foreach($categories as $category_id => $category_value)
                                <option value="{{ $category_id }}" selected="selected">{{ $category_value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-left">
                        <select class="form-control" name="tags[]" id="tag" multiple="multiple" style="width: 100%">
                            @foreach($tags as $tag_id => $tag_value)
                                <option value="{{ $tag_id }}" selected="selected">{{ $tag_value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="btn"> 取消 </button>
                        <button type="submit" class="btn btn-primary"> 保存 </button>
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <input id="title" value="{{ $note->title }}" name="title" type="title" class="form-control" placeholder="标题">
                @if ($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                <div id="test-editormd" style="width: 100%">
                    <textarea name="body" style="display:none">{{ $note->body }}</textarea>
                </div>
                @include('markdown::encode', ['editors' => ['test-editormd']])
                @if ($errors->has('body'))
                    <span class="help-block">
                        <strong>{{ $errors->first('body') }}</strong>
                    </span>
                @endif
            </div>
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