@extends('template.main')

@section('content')
    <div class="php">
        <p>
            Isi $data: {{ ($data ?? "Tidak ada") }}
            <br>
            Isi $status: {{ $status }}
        </p>
    </div>
@endsection