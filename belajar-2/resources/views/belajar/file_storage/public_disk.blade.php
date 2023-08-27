@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a href="/belajar-laravel/file-storage" class="btn btn-primary mb-3" role="button"><i class="bi bi-list-ul"></i> File Storage Index</a>

    <div class="card mb-5">
        <div class="card-body">
            <h5 class="card-title">Public Disk Put</h5>
            <p class="card-text">kalimat.txt Status Upload: <span @class(['badge', $statusUpload[1]])>{{ $statusUpload[0] }}</span></p>

            <hr>

            <h5 class="card-title">Public Disk Get</h5>
            <p class="card-text">kalimat.txt Content: <span @class(['badge', $contentKalimat[1]])">{{ $contentKalimat[0] }}</span></p>

            <hr>

            <h5 class="card-title">Public Disk Symbolic Link</h5>
            <p class="card-text"><a href="{{ $linkToKalimat }}" target="__blank" class="text-decoration-none">{{ $linkToKalimat }}</a></p>
            <p class="card-text"><a href="{{ $linkToDocument }}" target="__blank" class="text-decoration-none">{{ $linkToDocument }}</a></p>
            
            <p class="card-text"><a href="{{ $linkToImage }}" title="Go to Image" target="__blank" class="text-decoration-none"><img src="{{ $linkToImage }}" alt="Image" class="rounded mx-auto d-block" width="50%"></a></p>
        </div>
    </div>
@endsection