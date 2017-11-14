<form class="form-horizontal" role="form" method="POST" action="/notes">  
    {!! csrf_field() !!}

    <div class="form-group">
        <div class="row" style="border-bottom: 1px solid #ddd; padding: 8px 1% 8px 1%; margin: 0 -1.8% 0 -1.8%; background-color: #fff">
            <div class="col-md-3 text-left">
                <input id="category" name="category" type="category" class="form-control" placeholder="归类">
                @if ($errors->has('category'))
                <span class="help-block">
                    <strong>{{ $errors->first('category') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-md-9 text-right">
                <button type="submit" class="btn"> 取消 </button>
                <button type="submit" class="btn btn-primary"> 登录 </button>
            </div>
        </div>
    </div>

    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <input id="title" name="title" type="title" class="form-control" placeholder="标题">
        @if ($errors->has('title'))
        <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        <div id="test-editormd" style="width: 100%">
            <textarea name="body" style="display:none;"></textarea>
        </div>
        @include('markdown::encode', ['editors' => ['test-editormd']])
        @if ($errors->has('body'))
        <span class="help-block">
            <strong>{{ $errors->first('body') }}</strong>
        </span>
        @endif
    </div>

</form>