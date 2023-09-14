@extends('template.main')

@section('content')
    {{-- @dump(get_defined_vars()) --}}

    <h1 class="mt-5">{{ $title }}</h1>

    <a class="btn btn-primary mb-3" href="/belajar-laravel/validation" role="button"><i class="bi bi-list-ul"></i> Validation Index</a>

    {{-- 
        Displaying The Validation Errors

        So, what if the incoming request fields do not pass the given validation rules? As mentioned previously, Laravel will
        automatically redirect the user back to their previous location. In addition, all of the validation errors and request
        input will automatically be flashed to the session.

        An $errors variable is shared with all of your application's views by the
        Illuminate\View\Middleware\ShareErrorsFromSession middleware, which is provided by the web middleware group. When this
        middleware is applied an $errors variable will always be available in your views, allowing you to conveniently assume
        the $errors variable is always defined and can be safely used. The $errors variable will be an instance of
        Illuminate\Support\MessageBag. For more information on working with this object, check out its documentation.

        So, in our example, the user will be redirected back method when validation fails, allowing us to
        display the error messages in the view
    --}}

    @if (session('success') && session('data'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <ul>
                @foreach (session('data') as $key => $data)
                    @if (is_array($data))
                        <li>{{ $key }}</li>
                        <ol>
                            @foreach ($data as $value)
                                <li>{{ $value }}</li>
                            @endforeach
                        </ol>
                    @else
                        <li>{{ $key }} = {{ $data }}</li>
                    @endif
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif  

    @if ($errors->hasBag('nama_bebas'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->getBag('nama_bebas')->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{--
        Repopulating Forms

        When Laravel generates a redirect response due to a validation error, the framework will automatically flash all of the
        request's input to the session. This is done so that you may conveniently access the input during the next request and
        repopulate the form that the user attempted to submit.

        To retrieve flashed input from the previous request, invoke the old method on an instance of Illuminate\Http\Request.
        The old method will pull the previously flashed input data from the session

        Laravel also provides a global old helper. If you are displaying old input within a Blade template, it is more
        convenient to use the old helper to repopulate the form. If no old input exists for the given field, null will be
        returned
    --}}

    {{-- 
        The @error Directive
        
        You may use the @error Blade directive to quickly determine if validation error messages exist for a given attribute.
        Within an @error directive, you may echo the $message variable to display the error message

        If you are using named error bags, you may pass the name of the error bag as the second argument to the @error directive
    --}}

    <div class="card mb-5">
        <div class="card-body">
            <form action="{{ $actionUrl }}" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 input-group has-validation">
                    <label for="name-input" class="input-group-text">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" id="name-input" class="form-control @error('nama', 'nama_bebas') is-invalid @enderror">
                    @error('nama', 'nama_bebas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email-input" class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" id="email-input" class="form-control @error('email', 'nama_bebas') is-invalid @enderror">
                    {{-- 
                        Since the @error directive compiles to an "if" statement, you may use the @else directive to render content when there
                        is not an error for an attribute
                    --}}
                    @error('email', 'nama_bebas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @else
                        <div class="form-text">example@email.com</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md mb-3">
                        <label for="umur-input" class="form-label">Umur</label>
                        <input type="number" name="umur" value="{{ old('umur') }}" id="umur-input" class="form-control @error('umur', 'nama_bebas') is-invalid @enderror">
                        @error('umur', 'nama_bebas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md mb-3">
                        <label for="birthday" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="lahir" value="{{ old('lahir') }}" id="birthday" class="form-control @error('lahir', 'nama_bebas') is-invalid @enderror">
                        @error('lahir', 'nama_bebas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md mb-3">
                        <label for="tel-input" class="form-label">Nomor Telepon</label>
                        <input type="tel" name="telepon" value="{{ old('telepon') }}" id="tel-input" class="form-control @error('telepon', 'nama_bebas') is-invalid @enderror">
                        @error('telepon', 'nama_bebas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 input-group">
                    <label for="url-input" class="input-group-text">Social Media URL</label>
                    <input type="url" name="link" value="{{ old('link') }}" id="url-input" class="form-control @error('link', 'nama_bebas') is-invalid @enderror">
                    @error('link', 'nama_bebas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="file-input" class="form-label">File Upload</label>
                    <input type="file" name="file" id="file-input" class="form-control @error('file', 'nama_bebas') is-invalid @enderror">
                    @error('file', 'nama_bebas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <fieldset class="row mb-3">
                    <legend class="col-lg-1 col-form-label">Hobi:</legend>

                    <div class="col-lg-3">
                        <div class="form-check">
                            <input type="checkbox" name="hobi[]" value="belajar" id="hobi-1" class="form-check-input" @checked(!empty($belajar))>
                            <label for="hobi-1" class="form-check-label">Belajar</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="hobi[]" value="sepak bola" id="hobi-2" class="form-check-input" @checked(!empty($sepak_bola))>
                            <label for="hobi-2" class="form-check-label">Sepak Bola</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="hobi[]" value="bulutangkis" id="hobi-3" class="form-check-input" @checked(!empty($bulutangkis))>
                            <label for="hobi-3" class="form-check-label">Bulutangkis</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="hobi[]" value="musik" id="hobi-4" class="form-check-input" @checked(!empty($musik))>
                            <label for="hobi-4" class="form-check-label">Musik</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="hobi[]" value="bola basket" id="hobi-5" class="form-check-input" @checked(!empty($bola_basket))>
                            <label for="hobi-5" class="form-check-label">Bola Basket</label>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-check">
                            <input type="checkbox" name="hobi[]" value="memasak" id="hobi-6" class="form-check-input" @checked(!empty($memasak))>
                            <label for="hobi-6" class="form-check-label">Memasak</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="hobi[]" value="catur" id="hobi-7" class="form-check-input" @checked(!empty($catur))>
                            <label for="hobi-7" class="form-check-label">Catur</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="hobi[]" value="memanah" id="hobi-8" class="form-check-input" @checked(!empty($memanah))>
                            <label for="hobi-8" class="form-check-label">Memanah</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="hobi[]" value="melukis" id="hobi-9" class="form-check-input" @checked(!empty($melukis))>
                            <label for="hobi-9" class="form-check-label">Melukis</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="hobi[]" value="bermain game" id="hobi-10" class="form-check-input" @checked(!empty($bermain_game))>
                            <label for="hobi-10" class="form-check-label">Bermain Game</label>
                        </div>
                    </div>
                </fieldset>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="setuju" value="yes" id="accept-input" class="form-check-input @error('setuju', 'nama_bebas') is-invalid @enderror" @checked(old('setuju'))>
                    <label for="accept-input" class="form-check-label">I Accept Terms & Condition</label>
                    @error('setuju', 'nama_bebas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    
    @dump($errors)
    @dump(session()->all())
@endsection