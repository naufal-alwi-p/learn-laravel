<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $website_name }} | {{ $title }}</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
    <link rel="shortcut icon" href="/favicon.png" type="image/png">
</head>
<body>
    <h1>{{ $title }}</h1>

    @yield('content')
</body>
</html>