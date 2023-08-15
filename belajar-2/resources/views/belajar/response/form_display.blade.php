@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a class="btn btn-primary mb-3" href="/belajar-laravel/response/form-data" role="button"><i class="bi bi-journal-text"></i> Form Input</a>

    <div class="card mb-3">
        <div class="card-body">
            <div class="input-group mb-3">
                <span class="input-group-text">Full Name</span>
                <input type="text" class="form-control" disabled value="{{ $nama }}">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Email Address</span>
                <input type="email" class="form-control" disabled value="{{ $email }}">
            </div>
        </div>
    </div>
@endsection