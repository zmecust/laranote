<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link href="/css/app.css" rel="stylesheet" type="text/css">
    <link href="/vendor/markdown/css/editormd.min.css" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <style>
        html, body {
            margin: 0;
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div id="app">
        @yield('content') 
    </div>
</body>
<script src="/js/app.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
</html>
