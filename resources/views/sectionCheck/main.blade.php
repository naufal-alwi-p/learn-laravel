<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $website_name }} | Belajar Cek Section</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="shortcut icon" href="favicon.png" type="image/png">
</head>
<body>
    <h1>Belajar Cek Section Blade Template</h1>

    {{-- You may determine if a template inheritance section has content using the @@hasSection directive --}}
    @hasSection('content-1')
        <div class="php">
            @yield('content-1')
        </div>
    @endif

    @yield('content-2')

    @hasSection('content-2')
        <div class="php">
            Ini Muncul Jika ada section('content-2')
        </div>
    @endif

    {{-- You may use the sectionMissing directive to determine if a section does not have content --}}
    @sectionMissing('content-2')
        <div class="php">
            Ini Muncul Jika tidak ada section('content-2')
        </div>
    @endif
</body>
</html>