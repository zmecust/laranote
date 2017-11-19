@extends('note.master')
@section('content')
    <div class="login-container">
        <form class="form-horizontal" role="form" method="POST" action="/login">
            {!! csrf_field() !!}

            <h3 class="title">Laranote 您的专属笔记</h3>
            <button style="width: 100%; margin-bottom: 30px"> 登录 </button>
        </form>
    </div>
@stop