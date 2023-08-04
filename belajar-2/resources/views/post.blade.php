@extends('template.main')

@section('content')
    <article class="card mb-5">
        <div class="card-body">
            <h1 class="card-title mb-3">{{ $post->title }}</h1>
            <h6 class="card-subtitle text-body-secondary">Author: <a href="/author/{{ $post->user->username }}" class="text-decoration-none">{{ $post->user->name }}</a> | Category: <a href="/category/{{ $post->category->slug }}" class="text-decoration-none">{{ $post->category->category }}</a></h6>
            <hr class="mb-4">
            @foreach (explode("\n", $post->body) as $content)
                <p>{{ $content }}</p>
            @endforeach
        </div>
    </article>
@endsection