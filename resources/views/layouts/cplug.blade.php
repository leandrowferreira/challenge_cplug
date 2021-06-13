<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>@yield('titulo')</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Challenge Connect Plug">
        <meta name="author" content="Leandro Ferreira">

        <link rel="icon" href="/favicon.ico">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">


    </head>

    <body>
        <div id="app">

            @yield('container')

        </div>

        <script src="/js/app.js" defer></script>
        @yield('script')
    </body>

</html>
