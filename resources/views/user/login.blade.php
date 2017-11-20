@extends('note.master')
@section('content')
    <div class="login-container" style="padding-top: 10%">
        <form class="form-horizontal" role="form" method="POST" action="/">
            {!! csrf_field() !!}

            <h3 class="title">Laranote 您的专属笔记</h3>

            <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                <div class="col-md-4 col-md-offset-4">
                    <input id="login" name="login" type="text" class="form-control" placeholder="邮箱 / 用户名">
                    @if ($errors->has('login'))
                        <span class="help-block">
                            <strong>{{ $errors->first('login') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-4 col-md-offset-4">
                    <input type="password" class="form-control" name="password" placeholder="密码">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            @if(Session::has('user_login_failed'))
                <div class="col-md-4 col-md-offset-4 alert alert-danger text-center" role="alert">
                    {{ Session::get('user_login_failed') }}
                </div>
            @endif

            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-block btn-primary">
                        登录
                    </button>
                </div>
            </div>
        </form>
    </div>
@stop