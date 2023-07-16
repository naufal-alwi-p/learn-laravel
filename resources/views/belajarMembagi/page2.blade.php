@extends('belajarMembagi.main.utama')

@section('isi-content')
    <div class="php">
        <p>
            Kita di Page 2

            @include('belajarMembagi.component.text1') {{-- Kita bisa memisahkan beberapa komponen halaman web dan menggabungkannya sesuai kebutuhan dengan include --}}
        </p>
    </div>

    <h2>Penjelasan</h2>
    <div class="php">
        @verbatim
            <p>
                While you're free to use the @include directive, Blade components provide similar functionality and offer several
                benefits over the @include directive such as data and attribute binding.
            </p>
            <p>
                Blade's @include directive allows you to include a Blade view from within another view. All variables that are available
                to the parent view will be made available to the included view
            </p>
            <p>
                Even though the included view will inherit all data available in the parent view, you may also pass an array of
                additional data that should be made available to the included view
            </p>
            <p>
                If you attempt to @include a view which does not exist, Laravel will throw an error. If you would like to include a view
                that may or may not be present, you should use the @includeIf directive
            </p>
            <p>
                If you would like to @include a view if a given boolean expression evaluates to true or false, you may use the
                @includeWhen and @includeUnless directives
            </p>
            <p>
                To include the first view that exists from a given array of views, you may use the includeFirst directive
            </p>
            <p>
                You should avoid using the __DIR__ and __FILE__ constants in your Blade views, since they will refer to the location of
                the cached, compiled view.
            </p>
        @endverbatim
    </div>
@endsection