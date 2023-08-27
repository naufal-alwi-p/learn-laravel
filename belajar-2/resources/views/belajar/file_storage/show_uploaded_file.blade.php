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

    @if (session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-5">
        <div class="card-body">
            <h5 class="card-title">All Files in {{ $filesInUploadedFolder }}</h5>
            <ul>
                @forelse ($files as $file)
                    <li>
                        <div class="row">
                            <div class="col-8">
                                <a href="{{ $file['url'] }}" target="__blank" class="card-link text-decoration-none">{{ $file['name'] }}</a>
                            </div>
                            <div class="col">
                                {{ $file['visibility'] }}
                            </div>
                            <div class="col">
                                <a href="{{ $file['delete'] }}" class="card-link text-decoration-none">Hapus</a>
                            </div>
                        </div>
                    </li>
                @empty
                    <li><p class="card-text text-secondary">Kosong</p></li>
                @endforelse
            </ul>

            <hr>

            <h5 class="card-title">All Folder in {{ $rootFolderLocal }}</h5>
            <ul>
                @forelse ($directories as $directory)
                    <li><p class="card-text">{{ $directory }}</p></li>
                @empty
                    <li><p class="card-text text-secondary">Kosong</p></li>
                @endforelse
            </ul>

            <hr>

            <h5 class="card-title">makeDirectory() and deleteDirectory() Method</h5>
            <p class="card-text"><span class="badge text-bg-primary">{{ $statusFolderTes }}</span></p>
        </div>
    </div>
@endsection