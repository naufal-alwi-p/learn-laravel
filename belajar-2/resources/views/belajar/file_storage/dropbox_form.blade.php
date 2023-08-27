@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a href="/belajar-laravel/file-storage" class="btn btn-primary mb-3" role="button"><i class="bi bi-list-ul"></i> File Storage Index</a>

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            @foreach (session('info') as $key => $info)
                {{ $key }}: {{ $info }}

                @if (!$loop->last)
                    <br>
                @endif
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
            <form method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 row">
                    <div class="col">
                        <label for="file-upload" class="form-label">Select File</label>
                        <input class="form-control" type="file" id="file-upload" name="file_upload">
                    </div>
                    <div class="col">
                        <label for="file-name" class="form-label">Custom Name</label>
                        <input class="form-control" type="text" id="file-name" name="file_name" placeholder="Filename...">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection