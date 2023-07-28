<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $website_name }} | {{ $title }}</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    @includeWhen(($include_bootstrap), 'belajarMembagi.component.bootstrapHeader')
</head>
<body>
    @includeWhen(($include_bootstrap), 'belajarMembagi.component.navbar') {{-- Komponen akan di-include jika kodisi terpenuhi pada parameter pertama --}}
    {{-- Jika kondisi benar, maka komponen akan di-include --}}
    {{-- Jika kondisi salah, maka komponen tidak akan di-include --}}
    
    <div class="container">
        <h1>{{ $title }}</h1>

        @includeUnless(($include_bootstrap), 'belajarMembagi.component.noBootstrap') {{-- Komponen akan di-include jika kodisi tidak terpenuhi pada parameter pertama --}}
        {{-- Jika kondisi benar, maka file tidak akan di-include --}}
        {{-- Jika kondisi salah, maka file akan di-include --}}

        @include('belajarMembagi.component.komponen', ['info' => 'Yo! Selamat Datang di Channel Youtube ku']) {{-- Bagian yang di include dapat mengakses data yang ada di halaman yang dipanggil --}}
        {{-- Kita juga bisa mengirimkan data ke bagian yang akan kita include dengan mengirim data tersebut sebagai parameter kedua pada include --}}
        
        @yield('isi-content', 'Isi Konten Disini')

        @includeIf('belajarMembagi.component.text2') {{-- Jika file yang di-include tidak ada, maka tidak muncul dan tidak error (Default-nya bakal error) --}}

        @includeFirst(['belajarMembagi.component.text3', 'belajarMembagi.component.text2']) {{-- Jika salah satu ada, maka komponen yang tersebut akan ditampilkan --}}
        {{-- Jika dua-duanya tidak ada maka error --}}
        {{-- Jika keduanya ada, maka dipilih index paling awal --}}
    </div>

    @includeWhen(($include_bootstrap), 'belajarMembagi.component.bootstrapFooter')
</body>
</html>