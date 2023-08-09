@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a class="btn btn-primary mb-3" href="/belajar-laravel" role="button"><i class="bi bi-list-ul"></i> Daftar Isi</a>

    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text">
                Session Name = <span class="badge text-bg-success">{{ session()->getName() }}</span>
            </p>
            <hr>
            <p class="card-text">
                Session ID = <span class="badge text-bg-success">{{ session()->getId() }}</span>
            </p>
            <hr>
            <p class="card-text">
                Token = <span class="badge text-bg-success">{{ session()->token() }}</span>
            </p>
            <hr>
            <p class="card-text">
                Previous URL = <span class="badge text-bg-success">{{ session()->previousUrl() }}</span>
            </p>
            <hr>
            <p class="card-text">
                Default Drive = <span class="badge text-bg-success">{{ session()->getDefaultDriver() }}</span>
            </p>
        </div>
    </div>

    <p>session()->getDrivers()</p>
    @dump(session()->getDrivers())
    <p>session()->getOldInput()</p>
    @dump(session()->getOldInput())
    <p>session()->getSessionConfig()</p>
    @dump(session()->getSessionConfig())

    @if (session('info'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text">
                $request->hasSession(): <span class="badge text-bg-success">{{ $hasSession }}</span>
            </p>
            <hr>
            <p class="card-text">
                session('countInfo', 'null'): <span class="badge text-bg-success">{{ $countInfo }}</span>
            </p>
            <hr>
            <p class="card-text">
                $request->session()->get('_token'): <span class="badge text-bg-success">{{ $getItem1 }}</span>
            </p>
            <hr>
            <p class="card-text">
                $request->session()->get('nasi', 'Ga Ketemu'): <span class="badge text-bg-success">{{ $getItem2 }}</span>
            </p>
            <hr>
            <p class="card-text">
                session('_previous')['url']: <span class="badge text-bg-success">{{ $getItem3 }}</span>
            </p>
            <hr>
            <p class="card-text">
                session('minum', 'Kosong'): <span class="badge text-bg-success">{{ $getItem4 }}</span>
            </p>
            <hr>
            <p class="card-text">
                session('hobi', 'Ga Ada Hobi'): <span class="badge text-bg-success">{{ $getItem5 }}</span>
            </p>
            <hr>
            <p class="card-text">
                session('prodi'): <span class="badge text-bg-success">{{ $getItem6 }}</span>
            </p>
        </div>
    </div>

    <p>Via Session Helper Function</p>
    @dump($allDataSessionHelper)
    <p>Via Request Instance</p>
    @dump($allDataSessionRequest)
    <p>$arraySession1</p>
    @dump($arraySession1)
    <p>$counterSession</p>
    @dump($counterSession)
@endsection