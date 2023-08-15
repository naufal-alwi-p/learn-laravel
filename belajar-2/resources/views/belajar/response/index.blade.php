@extends('template.main')

@section('content')
<h1 class="mt-5">{{ $title }}</h1>

<a class="btn btn-primary mb-3" href="/belajar-laravel" role="button"><i class="bi bi-house-door-fill"></i> Belajar Laravel</a>

<div class="card mb-3">
    <div class="card-body">
        @forelse ($links as $link)
            <p class="card-text"><a href="/{{ $link->uri() }}" class="text-decoration-none">{{ $link->uri() }}</a></p>

            @if (!$loop->last)
                <hr>
            @endif
        @empty
            <p class="m-0 text-secondary">
                Kosong
            </p>
        @endforelse
    </div>
</div>
@endsection