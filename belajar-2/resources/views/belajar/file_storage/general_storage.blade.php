@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a href="/belajar-laravel/file-storage" class="btn btn-primary mb-3" role="button"><i class="bi bi-list-ul"></i> File Storage Index</a>

    <div class="card mb-5">
        <div class="card-body">
            <h5 class="card-title">Store the File Using Default Disk</h5>
            <p class="card-text">percakapan.txt put() Status: <span @class(['badge', $statusUploadPercakapan[1]])>{{ $statusUploadPercakapan[0] }}</span></p>
            <p class="card-text">percakapan.txt Content: <span @class(['badge', $percakapan[1]])>{{ $percakapan[0] }}</span></p>
            
            <hr>

            <h5 class="card-title">Store the File to Spesified Disk Using disk() Method</h5>
            <p class="card-text">pengumuman.txt put() Status: <span @class(['badge', $statusUploadPengumuman[1]])>{{ $statusUploadPengumuman[0] }}</span></p>
            <p class="card-text">pengumuman.txt Content: <span @class(['badge', $contentPengumuman[1]])>{{ $contentPengumuman[0] }}</span></p>

            <hr>

            <h5 class="card-title">Store the File On-Demand Disk</h5>
            <p class="card-text">coba.txt put() Method: <span @class(['badge', $statusUploadCoba[1]])>{{ $statusUploadCoba[0] }}</span></p>
            <p class="card-text">coba.txt Content: <span @class(['badge', $contentCoba[1]])>{{ $contentCoba[0] }}</span></p>

            <hr>

            <h5 class="card-title">Retrieving File Contains JSON</h5>
            <p class="card-text">data_json.txt put() Status: <span @class(['badge', $statusUploadJSON[1]])>{{ $statusUploadJSON[0] }}</span></p>
            <p class="card-text">data_json.txt Content:
                <br>
                @forelse ($contentJSON[0] as $key => $content)
                    @if (is_array($content))
                        {{ $key }}: <span @class(['badge', $contentJSON[1]])>{{ implode(', ', $content) }}</span>    
                    @else
                        {{ $key }}: <span @class(['badge', $contentJSON[1]])>{{ $content }}</span>    
                    @endif

                    @if (!$loop->last)
                        <br>
                    @endif
                @empty
                    <span @class(['badge', $contentJSON[1]])>File Tidak Ada</span>
                @endforelse
                
            </p>

            <hr>

            <h5 class="card-title">Check Whether File is Exist or Missing</h5>
            <p class="card-text">Is kalimat.txt -> exist: <span @class(['badge', $hasKalimat[1]])>{{ $hasKalimat[0] }}</span> | missing: <span @class(['badge', $missingKalimat[1]])>{{ $missingKalimat[0] }}</span></p>
            <p class="card-text">Is random.txt -> exist: <span @class(['badge', $hasRandom[1]])>{{ $hasRandom[0] }}</span> | missing: <span @class(['badge', $missingRandom[1]])>{{ $missingRandom[0] }}</span></p>

            <hr>

            <h5 class="card-title">File URLs</h5>
            <p class="card-text">Public Disk kalimat.txt URL: <span class="badge text-bg-success">{{ $UrlPublicKalimat }}</span></p>
            <p class="card-text">Public Disk kalimat.txt URL: <span class="badge text-bg-success">{{ $UrlPublicKalimat2 }}</span></p>
            <p class="card-text">Local Disk document-3.pdf URL: <span class="badge text-bg-success">{{ $UrlLocalDocument }}</span></p>

            <hr>

            <h5 class="card-title">File Metadata</h5>
            <p class="card-text">Public Disk percakapan.txt Size: <span class="badge text-bg-success">{{ $sizePublicPercakapan }}</span> bytes | <span class="badge text-bg-success">{{ round($sizePublicPercakapan / 1000000, 2) }}</span> Megabytes</p>
            <p class="card-text">Public Disk document-3.pdf Size: <span class="badge text-bg-success">{{ $sizeLocalDocument }}</span> bytes | <span class="badge text-bg-success">{{ round($sizeLocalDocument /1000000, 2) }}</span> Megabytes</p>
            <p class="card-text">Last Modified percakapan.txt: <span class="badge text-bg-success">{{ $lastPublicPercakapan }}</span></p>
            <p class="card-text">Last Modified document-3.pdf: <span class="badge text-bg-success">{{ $lastLocalDocument }}</span></p>
            <p class="card-text">MIME Type percakapan.txt: <span class="badge text-bg-success">{{ $mimePublicPercakapan }}</span></p>
            <p class="card-text">MIME Type document-3.pdf: <span class="badge text-bg-success">{{ $mimeLocalDocument }}</span></p>
            <p class="card-text">percakapan.txt Path: <span class="badge text-bg-success">{{ $pathPublicPercakapan }}</span></p>
            <p class="card-text">document-3.pdf Path: <span class="badge text-bg-success">{{ $pathLocalDocument }}</span></p>

            <hr>

            <h5 class="card-title">Storing Files</h5>
            <p class="card-text"><a href="{{ $urlImage1 }}" title="Go To Image" target="__blank" class="text-decoration-none"><img src="{{ $urlImage1 }}" alt="Image" class="rounded mx-auto d-block" width="50%"></a></p>

            <hr>

            <h5 class="card-title">Prepending & Appending To Files</h5>
            <p class="card-text">Public kalimat.txt Content: <span class="badge text-bg-success">{{ $PublicKalimat }}</span></p>

            <hr>

            <h5 class="card-title">Automatic Streaming</h5>
            <video controls width="100%" controlsList="nodownload">
                <source src="{{ $linkVideo2 }}" type="{{ $mimeVideo2 }}">

                Browser Tidak Support
            </video>
            <p class="card-text">anime-bochi.mp4 Path: <span class="badge text-bg-success">{{ $video2Path }}</span></p>
            <p class="card-text">anime-bochi.mp4 MIME Type: <span class="badge text-bg-success">{{ $mimeVideo2 }}</span></p>
            <p class="card-text">anime-bochi.mp4 URL: <span class="badge text-bg-success">{{ $linkVideo2 }}</span></p>


        </div>
    </div>
@endsection