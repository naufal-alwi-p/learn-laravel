@extends('template.main')

@section('content')
    <form class="container-fluid mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search something..." aria-label="Username" aria-describedby="basic-addon1">
            <span class="input-group-text" id="basic-addon1">Search</span>
        </div>
    </form>

    <h1 class="mb-3">Posts</h1>
    <div class="card mb-5 isi">
        @forelse ($posts as $post)
            <div class="card-body">
                <h3 class="card-title"><a href="/post/{{ $post->slug }}" class="text-decoration-none">{{ $post->title }}</a></h3>
                <h6 class="card-subtitle text-body-secondary">Author: <a href="/author/{{ $post->user->username }}" class="text-decoration-none">{{ $post->user->name }}</a> | Category: <a href="/category/{{ $post->category->slug }}" class="text-decoration-none">{{ $post->category->category }}</a></h6>
                <small class="mb-2 text-body-secondary">{{ $post->updated_at->diffForHumans() }}</small>
                <p class="card-text">{{ $post->excerpt }}</p>
                <a href="/post/{{ $post->slug }}" class="card-link">Read more</a>
            </div>
            @if (!$loop->last)
                <hr>
            @endif
        @empty
            <div class="card-body d-flex justify-content-center">
                <p class="m-0 text-secondary">
                    Kosong
                </p>
            </div>
        @endforelse
      </div>

      <script>
        const token = "{{ csrf_token() }}";
      </script>

      <script src="/js/home_ajax.js"></script>
@endsection