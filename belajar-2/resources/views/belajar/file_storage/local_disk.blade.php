@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a href="/belajar-laravel/file-storage" class="btn btn-primary mb-3" role="button"><i class="bi bi-list-ul"></i> File Storage Index</a>

    <div class="card mb-5">
        <div class="card-body">
            <h5 class="card-title">Local Disk Put</h5>
            <p class="card-text">tekt.txt Status Upload: <span @class(['badge', $statusUpload[1]])>{{ $statusUpload[0] }}</span></p>

            <hr>

            <h5 class="card-title">Local Disk Get</h5>
            <p class="card-text">teks.txt Content: <span @class(['badge', $contentTeks[1]])>{{ $contentTeks[0] }}</span></p>
        </div>
    </div>
@endsection