<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $website_name }} | {{ $title }}</title>
        <link rel="stylesheet" href="css/stylesheet.css">
        <link rel="shortcut icon" href="favicon.png" type="image/png">
    </head>
    <body>
        <h1>@yield('title-header', $title)</h1> {{-- yield menerima parameter kedua sebagai nilai default --}}
        <h1>@yield('title-header2')</h1>

        @section('head-content') {{-- Hubungkan section dengan yield yang sesuai, jika tidak dihubungkan maka tidak tampil tapi tidak error --}}
            <div class="php">
                <p>
                    Section ini (head-section) tidak akan muncul jika tidak di-yield di suatu tempat atau diakhiri show diakhir
                </p>
            </div>
        @endsection {{-- Jika section diakhiri dengan endSection, maka untuk bisa tampil harus ada yield yang memanggilnya --}}

        @section('head-content2')
            <div class="php">
                <p>
                    Jika sebuah section diakhiri dengan show maka sama saja dengan langsung meng-yield-kan section tersebut ditempat dia
                    dibuat
                </p>
            </div>
        @show {{-- Jika section diakhiri dengan show maka sama saja dengan langsung meng-yield-kan section tersebut ditempat dia dibuat --}}

        @section('head-content3')
            <div class="php">
                <p>
                    <b>Teks Ini akan di-overwrite</b>
                </p>
            </div>
        @show

        @verbatim
        <p>
            Layouts may also be created via "template inheritance". This was the primary way of building applications prior to the
            introduction of components.
        </p>
        <p>
            To get started, let's take a look at a simple example. First, we will examine a page layout. Since most web applications
            maintain the same general layout across various pages, it's convenient to define this layout as a single Blade view
        </p>
        <p>
            As you can see, this file contains typical HTML mark-up. However, take note of the @section and @yield directives. The
            @section directive, as the name implies, defines a section of content, while the @yield directive is used to display the
            contents of a given section.
        </p>
        <p>
            Now that we have defined a layout for our application, let's define a child page that inherits the layout.
        </p>
        @endverbatim

        @yield('head-content') {{-- Menampilkan section yang sesuai disini, jika tidak ada yang sesuai maka tidak tampil tapi tidak error --}}

        @yield('body-content')
    </body>
</html>