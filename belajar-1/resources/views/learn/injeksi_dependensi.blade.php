@extends('template.main')

@section('content')
    <ul>
        @forelse ($info_request_http as $key => $value)
            <li><b>{{ $key }}</b> = {{ $value }}</li>
        @empty
            <li>Data Kosong</li>
        @endforelse
    </ul>
@endsection