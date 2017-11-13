<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
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
        <div id="app">
            <div id="test-editormd">
               <textarea name="test-editormd" style="display:none;"></textarea>
            </div>
            @include('markdown::encode',['editors'=>['test-editormd']])
        </div>
        <script src="./js/app.js"></script>
    </body>
</html>
