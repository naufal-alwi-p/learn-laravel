@extends('belajarMembagi.main.utamaBelajar') {{-- Pilih file yang akan jadi template utama yang akan digunakan --}}

@section('title-header2', 'Belajar Section') {{-- Hubungkan section dengan yield yang sesuai nama dalam file yang di-extends --}}
{{-- Jika hanya ingin mengisi satu baris saja bisa langsung memberi nilainya sebagai parameter kedua pada section tanpa harus mengakhirinya dengan endSection atau show --}}

@section('head-content')
    @parent {{-- Tambahan konten pada section 'head-content' tanpa men-overwrite isi sebelumnya --}}

    <div class="php">
        <p>
            Tambahan untuk head-content section
        </p>
    </div>
@endsection

@section('head-content3')
    {{-- Jika tidak ada parent seperti contoh diatas, maka isi sebelumnya pada section ini akan di-overwrite --}}
    <div class="php">
        <p>
            Teks ini menimpa sesuatu
        </p>
    </div>
@endsection

@section('body-content')
    <h2>Extending A Layout</h2>
    <div class="php">
        @verbatim
            <p>
                When defining a child view, use the @extends Blade directive to specify which layout the child view should "inherit".
                Views which extend a Blade layout may inject content into the layout's sections using @section directives. Remember, as
                seen in the example above, the contents of these sections will be displayed in the layout using @yield
            </p>
            <p>
                In this example, the sidebar section is utilizing the @parent directive to append (rather than overwriting) content to
                the layout's sidebar. The @parent directive will be replaced by the content of the layout when the view is rendered.
            </p>
            <p>
                Contrary to the previous example, this sidebar section ends with @endsection instead of @show. The @endsection directive
                will only define a section while @show will define and immediately yield the section.
            </p>
            <p>
                The @yield directive also accepts a default value as its second parameter. This value will be rendered if the section
                being yielded is undefined
            </p>
        @endverbatim
        @if ($cek_halaman_sebelah)
            @php
                var_dump($cek_halaman_sebelah);
            @endphp
            Halaman page2.blade.php Ada
            <p>
                <a href="/page2">Ke page 2</a>
            </p>
        @else
        @php
            var_dump($cek_halaman_sebelah);
        @endphp
        Halaman page2.blade.php Tidak Ada
        @endif
    </div>
@endsection