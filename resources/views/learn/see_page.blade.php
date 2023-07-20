@extends('template.main')

@section('content')
    <div class="php">
        <p>
            Ini diakses dengan menggunakan Route::view()
        </p>
        <p>
            Ada data: {{ $data }}
        </p>
    </div>
@endsection