@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a href="/belajar-laravel/request/form-input-request-http" class="btn btn-primary mb-3" role="button"><i class="bi bi-journal-text"></i> Form Input</a>

    <div class="card mb-5">
        <div class="card-body">
            <h5 class="card-title">Retrieving All Input Data</h5>
            <p class="card-text mb-0">Retrieving All Input as Array:</p>
                @forelse ($allInputArray as $key => $value)

                    @if (is_array($value))
                        <p class="card-text my-0 ms-2">{{ $key }}:</p>

                        @forelse ($value as $isi)
                            <p class="card-text my-0 ms-4">- <span class="badge text-bg-success">{{ $isi }}</span></p>
                        @empty
                            <p class="card-text my-0 ms-4"><span class="badge text-bg-secondary">Kosong</span></p>
                        @endforelse
                    @else
                        <p class="card-text my-0 ms-2">{{ $key }}: <span class="badge text-bg-success">{{ $value }}</span></p>
                    @endif

                @empty
                    <p class="card-text my-0"><span class="badge text-bg-secondary">Kosong</span></p>
                @endforelse
            
            <p class="card-text mb-0 mt-4">Retrieving All Input as Collection:</p>
                @forelse ($allInputCollect as $key => $value)

                    @if (is_array($value))
                        <p class="card-text my-0 ms-2">{{ $key }}:</p>

                        @forelse ($value as $isi)
                            <p class="card-text my-0 ms-4">- <span class="badge text-bg-success">{{ $isi }}</span></p>
                        @empty
                            <p class="card-text my-0 ms-4"><span class="badge text-bg-secondary">Kosong</span></p>
                        @endforelse
                    @else
                        <p class="card-text my-0 ms-2">{{ $key }}: <span class="badge text-bg-success">{{ $value }}</span></p>
                    @endif

                @empty
                    <p class="card-text my-0"><span class="badge text-bg-secondary">Kosong</span></p>
                @endforelse
            
            <hr>

            <h5 class="card-title">Retrieving An Input Value</h5>
            <p class="card-text">Password: <span class="badge text-bg-success">{{ $pw1 }}</span></p>
            <p class="card-text">Email: <span class="badge text-bg-success">{{ $email1 }}</span></p>
            <p class="card-text">Array Olahraga: <span class="badge text-bg-success">{{ $arrOlahraga }}</span></p>
            <p class="card-text">Query URL Universitas: <span class="badge text-bg-success">{{ $universitas }}</span></p>

            <hr>

            <h5 class="card-title">Retrieving Input From The Query String</h5>
            <p class="card-text">Universitas: <span class="badge text-bg-success">{{ $universitas2 }}</span></p>
            <p class="card-text">Jenjang: <span class="badge text-bg-success">{{ $jenjang }}</span></p>
            <p class="card-text">Umur: <span class="badge text-bg-success">{{ $umur }}</span></p>
            <p class="card-text">Nama: <span class="badge text-bg-success">{{ $nama1 }}</span></p>
            <p class="card-text">Tes: <span class="badge text-bg-success">{{ $tes }}</span></p>

            <hr>

            <h5 class="card-title">Retrieving Stringable Input Values</h5>
            <p class="card-text">Stringabel Username: <span class="badge text-bg-success">{{ $username1 }}</span></p>

            <hr>

            <h5 class="card-title">Retrieving Boolean Input Values</h5>
            <p class="card-text">Boolean Notification Value: <span class="badge text-bg-success">{{ $notification1 }}</span></p>

            <hr>

            <h5 class="card-title">Retrieving Date Input Values</h5>
            <p class="card-text">Flight Schedule: <span class="badge text-bg-success">{{ $schedule }}</span></p>

            <hr>

            <h5 class="card-title">Retrieving Input Via Dynamic Properties</h5>
            <p class="card-text">Username: <span class="badge text-bg-success">{{ $username2 }}</span></p>
            <p class="card-text">Nickname: <span class="badge text-bg-success">{{ $nama2 }}</span></p>
            <p class="card-text">Univesitas: <span class="badge text-bg-success">{{ $universitas3 }}</span></p>

            <hr>

            <h5 class="card-title">Retrieving A Portion Of The Input Data</h5>
            <p class="card-text mb-0">only() Method:</p>
                @forelse ($subsetData1 as $key => $value)

                    @if (is_array($value))
                        <p class="card-text my-0 ms-2">{{ $key }}:</p>

                        @forelse ($value as $isi)
                            <p class="card-text my-0 ms-4">- <span class="badge text-bg-success">{{ $isi }}</span></p>
                        @empty
                            <p class="card-text my-0 ms-4"><span class="badge text-bg-secondary">Kosong</span></p>
                        @endforelse
                    @else
                        <p class="card-text my-0 ms-2">{{ $key }}: <span class="badge text-bg-success">{{ $value }}</span></p>
                    @endif

                @empty
                    <p class="card-text my-0"><span class="badge text-bg-secondary">Kosong</span></p>
                @endforelse

            <p class="card-text mb-0 mt-4">except() Method:</p>
                @forelse ($subsetData2 as $key => $value)

                    @if (is_array($value))
                        <p class="card-text my-0 ms-2">{{ $key }}:</p>

                        @forelse ($value as $isi)
                            <p class="card-text my-0 ms-4">- <span class="badge text-bg-success">{{ $isi }}</span></p>
                        @empty
                            <p class="card-text my-0 ms-4"><span class="badge text-bg-secondary">Kosong</span></p>
                        @endforelse
                    @else
                        <p class="card-text my-0 ms-2">{{ $key }}: <span class="badge text-bg-success">{{ $value }}</span></p>
                    @endif

                @empty
                    <p class="card-text my-0"><span class="badge text-bg-secondary">Kosong</span></p>
                @endforelse

            <hr>

            <h5 class="card-title">Determining If Input Is Present</h5>
            <p class="card-text">Has Email: <span class="badge text-bg-success">{{ $hasEmail }}</span></p>
            <p class="card-text">Has Address: <span class="badge text-bg-success">{{ $hasAddress }}</span></p>
            <p class="card-text">Has All of This Input: <span class="badge text-bg-success">{{ $hasAllOfThisInput }}</span></p>
            <p class="card-text">Has One of This Input: <span class="badge text-bg-success">{{ $hasOneOfThisInput }}</span></p>
            <br>
            <p class="card-text">Filled Email: <span class="badge text-bg-success">{{ $filledEmail }}</span></p>
            <p class="card-text">Filled All of This Input: <span class="badge text-bg-success">{{ $filledAllOfThisInput }}</span></p>
            <p class="card-text">Filled One of This Input: <span class="badge text-bg-success">{{ $filledOneOfThisInput }}</span></p>
            <br>
            <p class="card-text">Missing Email: <span class="badge text-bg-success">{{ $missingEmail }}</span></p>
            <p class="card-text">Missing Address: <span class="badge text-bg-success">{{ $missingAddress }}</span></p>
            <p class="card-text">Missing All of This Input: <span class="badge text-bg-success">{{ $missingAllOfThisInput }}</span></p>

            <hr>
            
            <h5 class="card-title">Merging Additional Input</h5>
            <p class="card-text mb-0">Tambahan Input:</p>
                @forelse ($withAdditionalInput as $key => $value)

                    @if (is_array($value))
                        <p class="card-text my-0 ms-2">{{ $key }}:</p>

                        @forelse ($value as $isi)
                            <p class="card-text my-0 ms-4">- <span class="badge text-bg-success">{{ $isi }}</span></p>
                        @empty
                            <p class="card-text my-0 ms-4"><span class="badge text-bg-secondary">Kosong</span></p>
                        @endforelse
                    @else
                        <p class="card-text my-0 ms-2">{{ $key }}: <span class="badge text-bg-success">{{ $value }}</span></p>
                    @endif

                @empty
                    <p class="card-text my-0"><span class="badge text-bg-secondary">Kosong</span></p>
                @endforelse
            
            <hr>

            <h5 class="card-title">Retrieving Cookies From Requests</h5>
            <p class="card-text">Has laravel_session Cookie: <span class="badge text-bg-success">{{ $haslaravel_sessionCookie }}</span></p>
            <p class="card-text">XSRF_TOKEN Cookie: <span class="badge text-bg-success">{{ $XSRFTokenCookie }}</span></p>
            <p class="card-text mb-0">All Cookies:</p>
                @forelse ($allCookies as $key => $cookie)
                    <p class="card-text my-0 ms-2">{{ $key }}: <span class="badge text-bg-success">{{ is_null($cookie) ? 'null' : $cookie }}</span></p>
                @empty
                    <p class="card-text my-0"><span class="badge text-bg-secondary">Kosong</span></p>
                @endforelse

        </div>
    </div>

    @dump($allDataSession)
@endsection