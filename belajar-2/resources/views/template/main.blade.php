<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $website_name }} | {{ $title }}</title>
        <link rel="shortcut icon" href="/favicon.png" type="image/png">
        @include('component.CssBootstrap')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </head>
    <body class="bg-body-tertiary">
        @includeUnless(\Illuminate\Support\Facades\Request::is("belajar-laravel*"), 'component.navbar')
        
        <div class="container">
            @yield('content')
            
        </div>
        @include('component.JsBootstrap')
    </body>
</html>