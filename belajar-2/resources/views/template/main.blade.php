<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $website_name }} | {{ $title }}</title>
        <link rel="shortcut icon" href="/favicon.png" type="image/png">
        @include('component.CssBootstrap')
    </head>
    <body class="bg-body-tertiary">
        @include('component.navbar')
        
        <div class="container">
            @yield('content')
            
            @include('component.JsBootstrap')
        </div>
    </body>
</html>