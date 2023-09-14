@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a class="btn btn-primary mb-3" href="/belajar-laravel/validation" role="button"><i class="bi bi-list-ul"></i> Validation Index</a>

    <div class="card mb-3" id="form-card">
        <div class="card-body">
            <form autocomplete="off">
                @csrf
                <div class="mb-3 row">
                    <label for="name-input" class="col-1 col-form-label">Name</label>
                    <div class="col-11">
                        <input type="text" name="name" id="name-input" class="form-control">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email-input" class="col-1 col-form-label">Email</label>
                    <div class="col-11">
                        <input type="email" name="email" id="email-input" class="form-control">
                    </div>
                </div>
                <button type="button" id="button-send" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="card mb-5" id="box-result" style="display:none;">
        <div class="card-body">
            <div class="row">
                <div class="col-11 d-flex">
                    <pre id="json-display" class="card-text align-self-center text-wrap"></pre>
                </div>
                <div class="col-1">
                    <button type="button" id="hide-btn" class="btn btn-danger">Hide</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/xhr_validation.js"></script>
@endsection