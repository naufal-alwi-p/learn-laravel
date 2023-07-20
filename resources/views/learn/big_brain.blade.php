@extends('template.main')

@section('content')
    <div class="php">
        Ini Page Big Brain
        <br>
        url: {{ $generate }}
        <br>
        Info: {{ $data ?? 'null' }}
        <br>
        Check Named Route: {{ ($check_named_route) ? 'true' : 'false' }}
        <br>
        Route Name: {{ $named_route }}
    </div>
@endsection