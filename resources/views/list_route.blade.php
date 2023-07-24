@extends('template.main')

@section('content')
    <ul>
        @forelse ($list as $route)
            @php
                $text = $route->uri();
            @endphp
            
            @if (str_contains($text, '}'))
                <li>{{ $text }}</li>
            @else
                <li><a href="/{{ $text }}">{{ $text }}</a></li>
            @endif
        @empty
            <li>Tidak Ada Route</li>
        @endforelse
    </ul>
    
@endsection