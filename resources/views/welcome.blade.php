<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>
        <link rel="icon" href="{{url('assets/logo.png')}}" type="image/ico" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">

    </head>
    <div id="app">
        <app></app>
        </div>
    <body>

    </body>
    <script src={{asset('js/app.js')}}></script>

</html>
