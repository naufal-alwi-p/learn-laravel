@extends('template.main')

@section('content')
    <div class="php">
        Ini menu {{ $menu }} dari user dengan ID {{ $id }}
        <br>
        {{ $func }} controller method
    </div>
    <div class="php">
        <ul>
            @forelse ($info_request_http as $key => $value)
                <li><b>{{ $key }}</b> = {{ $value }}</li>
            @empty
                <li>Kosong</li>
            @endforelse
        </ul>
    </div>
@endsection