@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a class="btn btn-primary mb-3" href="/belajar-laravel/validation" role="button"><i class="bi bi-list-ul"></i> Validation Index</a>

    @error('error_info')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror

    @if (session('pass'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('pass')[0] }}
            <br>
            @dump(session('pass')[1])
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-5">
        <div class="card-body">
            <form action="{{ $actionUrl }}" method="post" class="form-input" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="data" class="form-label">Input Data</label>
                    <input type="text" name="data" value="{{ old('data') }}" id="data" class="form-control @error('data') is-invalid @enderror">
                    @error('data')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="data_confirmation" class="form-label">Confirmation Data</label>
                    <input type="text" name="data_confirmation" value="{{ old('data_confirmation') }}" id="data_confirmation" class="form-control @error('data_confirmation') is-invalid @enderror">
                    @error('data_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="cek" value="true" id="cek" class="form-check-input @error('cek') is-invalid @enderror" disabled @checked(old('cek'))>
                    <label for="cek" class="form-check-label">Check</label>
                    @error('cek')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="file_upload" class="form-label">File Upload</label>
                    <input type="file" name="file_upload" id="file_upload" class="form-control @error('file_upload') is-invalid @enderror" disabled>
                    @error('file_upload')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="opsi" class="form-label">Validation Rule</label>
                    <select name="opsi" id="opsi" class="form-select">
                        <option value="default" @selected(old('opsi') === 'default')>Default</option>
                        <option value="accepted" @selected(old('opsi') === 'accepted')>accepted</option>
                        <option value="accepted_if" @selected(old('opsi') === 'accepted_if')>accepted_if</option>
                        <option value="active_url" @selected(old('opsi') === 'active_url')>active_url</option>
                        <option value="after" @selected(old('opsi') === 'after')>after</option>
                        <option value="alpha" @selected(old('opsi') === 'alpha')>alpha</option>
                        <option value="alpha_dash" @selected(old('opsi') === 'alpha_dash')>alpha_dash</option>
                        <option value="alpha_num" @selected(old('opsi') === 'alpha_num')>alpha_num</option>
                        <option value="array" @selected(old('opsi') === 'array')>array</option>
                        <option value="ascii" @selected(old('opsi') === 'ascii')>ascii</option>
                        <option value="bail" @selected(old('opsi') === 'bail')>bail</option>
                        <option value="size(string)" @selected(old('opsi') === 'size(string)')>size(string)</option>
                        <option value="size(numeric)" @selected(old('opsi') === 'size(numeric)')>size(numeric)</option>
                        <option value="size(array)" @selected(old('opsi') === 'size(array)')>size(array)</option>
                        <option value="between(file)" @selected(old('opsi') === 'between(file)')>between(file)</option>
                        <option value="confirmed" @selected(old('opsi') === 'confirmed')>confirmed</option>
                        <option value="decimal" @selected(old('opsi') === 'decimal')>decimal</option>
                        <option value="digit" @selected(old('opsi') === 'digit')>digit</option>
                        <option value="dimensions" @selected(old('opsi') === 'dimensions')>dimensions</option>
                        <option value="exists" @selected(old('opsi') === 'exists')>exists</option>
                        <option value="in" @selected(old('opsi') === 'in')>in</option>
                        <option value="ipv6" @selected(old('opsi') === 'ipv6')>ipv6</option>
                        <option value="mimetypes" @selected(old('opsi') === 'mimetypes')>mimetypes</option>
                        <option value="multiple_of" @selected(old('opsi') === 'multiple_of')>multiple_of</option>
                        <option value="same" @selected(old('opsi') === 'same')>same</option>
                        <option value="unique" @selected(old('opsi') === 'unique')>unique</option>
                        <option value="conditionally adding rules" @selected(old('opsi') === 'conditionally adding rules')>conditionally adding rules</option>
                        <option value="required_array_keys" @selected(old('opsi') === 'required_array_keys')>required_array_keys</option>
                        <option value="validating arrays" @selected(old('opsi') === 'validating arrays')>validating arrays</option>
                        <option value="validating files" @selected(old('opsi') === 'validating files')>validating files</option>
                        <option value="validating passwords" @selected(old('opsi') === 'validating passwords')>validating passwords</option>
                        <option value="custom validation rules" @selected(old('opsi') === 'custom validation rules')>custom validation rules</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    @dump(session()->all())

    <script src="/js/validation.js"></script>
@endsection