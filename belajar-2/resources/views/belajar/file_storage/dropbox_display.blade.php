@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a href="/belajar-laravel/file-storage" class="btn btn-primary mb-3" role="button"><i class="bi bi-list-ul"></i> File Storage Index</a>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('fail'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('fail') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-5">
        <div class="card-body">
            @forelse ($files as $file)
                <h5 class="card-title">{{ $file['filename'] }}</h5>
                <div class="row">
                    <div class="col">
                        @if (Illuminate\Support\Str::is('image/*', $file['mimeType']))
                            <img src="{{ $file['sourceUrl'] }}" alt="{{ $file['filename'] }}" class="img-fluid">
                        @elseif (Illuminate\Support\Str::is('audio/*', $file['mimeType']))
                            <audio controls controlsList="nodownload" class="d-block mx-auto">
                                <source src="{{ $file['sourceUrl'] }}" type="{{ $file['mimeType'] }}">
                                Browser Tidak Support audio Tag
                            </audio>
                        @elseif (Illuminate\Support\Str::is('video/*', $file['mimeType']))
                            <video controls class="ratio ratio-16x9" controlsList="nodownload">
                                <source src="{{ $file['sourceUrl'] }}" type="{{ $file['mimeType'] }}">
                                    Browser Tidak Support video Tag
                            </video>
                        @elseif (Illuminate\Support\Str::is('*/pdf', $file['mimeType']))
                            <embed src="{{ $file['sourceUrl'] }}" type="{{ $file['mimeType'] }}" class="ratio ratio-1x1" height="500px">
                        @endif
                    </div>
                    <div class="col">
                        <p class="card-text">Path: <span class="badge text-bg-success">{{ $file['path'] }}</span></p>
                        <p class="card-text">Last Modified: <span class="badge text-bg-success">{{ $file['lastModified'] }}</span></p>
                        <p class="card-text">Size: <span class="badge text-bg-success">{{ round($file['size'] / 1000000, 2) }} MB</span></p>
                        <p class="card-text">MIME Type: <span class="badge text-bg-success">{{ $file['mimeType'] }}</span></p>
                        <a href="{{ $file['downloadUrl'] }}" target="__blank" class="btn btn-success mb-3"><i class="bi bi-download"></i> Download</a>
                        <form action="/belajar-laravel/file-storage/delete-dropbox-uploaded-file" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="filename" value="{{ $file['filename'] }}" class="btn btn-danger"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>

                @if (!$loop->last)
                    <hr>
                @endif
            @empty
                <p class="card-text text-secondary">Kosong</p>
            @endforelse
        </div>
    </div>
@endsection