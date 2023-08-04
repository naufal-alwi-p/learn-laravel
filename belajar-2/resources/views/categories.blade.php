@extends('template.main')

@section('content')
    <h1 class="mb-3">{{ $title }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            @forelse ($categories as $category)
                <p class="card-text"><a href="/category/{{ $category->slug }}" class="text-decoration-none">{{ $category->category }}</a></p>

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