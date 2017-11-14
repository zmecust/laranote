<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link href="/css/app.css" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <style>
        html, body {
            height: 100vh;
            margin: 0;
            background-color: #eee;
        }
    </style>
</head>
<body>
    <div id="app">
        @yield('content') 
    </div>
</body>
<script src="/js/app.js"></script>
</html>
