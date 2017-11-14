<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laranote | login</title>
    <link href="./css/app.css" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #008080;
            color: #333;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="col-md-4 col-md-offset-4 col-xs-12">
        <form class="form-default" role="form" method="POST" action="/user/login">  
            {!! csrf_field() !!}

            <div class="form">
                <input id="login" name="login" type="text" class="form-login" placeholder="邮箱 / 用户名">
                @if ($errors->has('login'))
                    <span class="help-block">
                    <strong>{{ $errors->first('login') }}</strong>
                </span>
                @endif
            </div>

            <div class="form">
                <input type="password" class="form-login" name="password" placeholder="密码">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            @if(Session::has('user_login_failed'))
                <div class="col-md-10 col-md-offset-1 alert alert-danger text-center" role="alert">
                    {{ Session::get('user_login_failed') }}
                </div>
            @endif

            @if(Session::has('user_verify_failed'))
                <div class="col-md-10 col-md-offset-1 alert alert-danger text-center" role="alert">
                    {{ Session::get('user_verify_failed') }}
                </div>
            @endif

            <div class="form-group">
                <div class="col-md-10 col-md-offset-1">
                    <button type="submit" class="btn btn-block btn-primary">
                        登录
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
