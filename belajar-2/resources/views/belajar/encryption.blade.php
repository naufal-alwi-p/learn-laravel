@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a class="btn btn-primary mb-3" href="/belajar-laravel" role="button"><i class="bi bi-house-door-fill"></i> Belajar Laravel</a>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text">Crypt Key: <span class="badge text-bg-success">{{ $crypt_key }}</span></p>
            <p class="card-text">Generated Key: <span class="badge text-bg-success">{{ $generated_key }}</span></p>
            <p class="card-text">Generated Key 2: <span class="badge text-bg-success">{{ $generated_key2 }}</span></p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="post" autocomplete="off">
                @csrf
                <div class="mb-3 row">
                    <div class="col-10">
                        <label for="text-input" class="form-label">Input</label>
                        <textarea name="input" id="text-input" rows="10" class="form-control">{{ old('input') }}</textarea>
                    </div>
                    <div class="col-2">
                        <div class="mb-3">
                            <label for="select-option" class="form-label">Option</label>
                            <select name="option" id="select-option" class="form-select">
                                <option value="encrypt" @selected(old('option') === 'encrypt')>Encrypt</option>
                                <option value="decrypt" @selected(old('option') === 'decrypt')>Decrypt</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="select-serialize" class="form-label">Serialize</label>
                            <select name="serialize" id="select-serialize" class="form-select">
                                <option value="true" @selected(old('serialize') === 'true')>True</option>
                                <option value="false" @selected(old('serialize') === 'false')>False</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>

    @if (session('text'))
        <div class="card mb-5">
            <div class="card-body">
                <h5 class="card-title">Text</h5>
                <p class="card-title">{{ session('text') }}</p>

                <hr>
            @if (session('encrypt'))
                <h5 class="card-title">Encrypt</h5>
                <p class="card-text">{{ session('encrypt') }}</p>
            @elseif (session('decrypt'))
                <h5 class="card-title">Decrypt</h5>
                <p class="card-text">{{ session('decrypt') }}</p>
            @endif
            </div>
        </div>
    @endif

@endsection