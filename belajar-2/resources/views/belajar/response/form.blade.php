@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a class="btn btn-primary mb-3" href="/belajar-laravel/response" role="button"><i class="bi bi-list-ul"></i> Response Index</a>

    {{-- After the user is redirected, you may display the flashed message from the session. For example, using Blade syntax --}}
    @if (session('gagal'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('gagal') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form method="POST" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="nama" name="name" value="{{ old('name', 'Kosong') }}">
                </div>
                <div class="mb-3">
                    <label for="input-email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="input-email" name="email" aria-describedby="emailHelp" value="{{ old('email', 'Kosong') }}">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="input-password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="input-password" name="pw" value="{{ old('pw') }}">
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    @dump(session()->all())
@endsection