@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a class="btn btn-primary mb-3" href="/belajar-laravel/validation" role="button"><i class="bi bi-list-ul"></i> Validation Index</a>

    <div class="card mb-5">
        <div class="card-body">
            <form action="{{ $actionUrl }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name-input" class="form-label">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" id="name-input" class="form-control @error('nama') is-invalid @enderror">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email-input" class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" id="email-input" class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="form-text">example@email.com</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="daftar-input" class="form-label">Tanggal Daftar</label>
                    <input type="date" name="daftar" value="{{ old('daftar') }}" id="daftar-input" class="form-control @error('daftar') is-invalid @enderror">
                    @error('daftar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection