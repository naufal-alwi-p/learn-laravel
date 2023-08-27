@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a href="/belajar-laravel/file-storage" class="btn btn-primary mb-3" role="button"><i class="bi bi-list-ul"></i> File Storage Index</a>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            File sukses di upload: {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('tes'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{ session('tes') }}
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
                {{-- <input type="hidden" name="MAX_FILE_SIZE" value="500"> --}}
                <div class="mb-3">
                    <label for="file-upload-1" class="form-label">Select File 1</label>
                    <input class="form-control" type="file" id="file-upload-1" name="file_upload1">
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="file-upload-2" class="form-label">Select File 2</label>
                        <input class="form-control" type="file" id="file-upload-2" name="file_upload2">
                    </div>
                    <div class="col">
                        <label for="file-name-2" class="form-label">Custom Name 2</label>
                        <input class="form-control" type="text" id="file-name-2" name="file_name2" placeholder="Filename...">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="file-upload-3" class="form-label">Select File 3</label>
                        <input class="form-control" type="file" id="file-upload-3" name="file_upload3">
                    </div>
                    <div class="col">
                        <label for="file-name-3" class="form-label">Custom Name 3</label>
                        <input class="form-control" type="text" id="file-name-3" name="file_name3" placeholder="Filename...">
                    </div>
                    <div class="col">
                        <label for="disk-3" class="form-label">Select Disk</label>
                        <select class="form-select" name="disk_3" id="disk-3">
                            <option value="public" selected>Public</option>
                            <option value="local">Local</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="visibility-3" class="form-label">Select Visibility 3</label>
                    <select class="form-select" name="visibility_3" id="visibility-3">
                        <option value="public" selected>Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    @if (session('file_info3'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            @foreach (session('file_info3') as $key => $value)
                {{ str_replace('_', ' ', $key) }}: {{ $value }}

                @if (!$loop->last)
                    <br>
                @endif
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endsection