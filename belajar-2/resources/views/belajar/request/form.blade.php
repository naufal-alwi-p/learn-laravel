@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a href="/belajar-laravel/request" class="btn btn-primary mb-3" role="button"><i class="bi bi-list-ul"></i> Request Index</a>

    <div class="card mb-5 bg-success-subtle">
        <div class="card-body">
            <form method="POST" action="{{ $action_url }}">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="text" class="form-control" name="username" value="{{ $username }}" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                </div>

                <div class="mb-3">
                    <label for="email-form" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email-form" name="email" value="{{ $email }}" aria-describedby="emailHelp" placeholder="example@email.com">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>

                <div class="mb-3">
                    <label for="date-form" class="form-label">Flight Schedule</label>
                    <input type="date" class="form-control" name="waktu" value="{{ $waktu }}" id="date-form">
                </div>

                <div class="mb-3 input-group">
                    <span class="input-group-text">Password</span>
                    <input type="password" class="form-control" id="password-form" name="password">
                </div>

                <div class="mb-3">
                    <label for="game-console" class="form-label">Game Console</label>
                    <select name="game_console[]" id="game-console" size="4" class="form-select" multiple>
                        <option value="Playstation" @selected(!empty($Playstation))>Playstation</option>
                        <option value="Xbox" @selected(!empty($Xbox))>Xbox</option>
                        <option value="Nintendo" @selected(!empty($Nintendo))>Nintendo</option>
                        <option value="Steam Deck" @selected(!empty($Steam_Deck))>Steam Deck</option>
                    </select>
                </div>

                <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-1 pt-0">Kelas:</legend>
                    <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="kelas" id="kelas-10" value="10" @checked($kelas == 10)>
                        <label class="form-check-label" for="kelas-10">
                            10
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="kelas" id="kelas-11" value="11" @checked($kelas == 11)>
                        <label class="form-check-label" for="kelas-11">
                          11
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="kelas" id="kelas-12" value="12" @checked($kelas == 12)>
                        <label class="form-check-label" for="kelas-12">
                          12
                        </label>
                      </div>
                    </div>
                  </fieldset>

                  <fieldset class="row mb-3">
                    <legend class="col-form-label col-sm-1 pt-0">Olahraga:</legend>
                    <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="olahraga[]" value="Sepak Bola" @checked(!empty($Sepak_Bola)) id="olahraga-1">
                        <label class="form-check-label" for="olahraga-1">
                            Sepak Bola
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="olahraga[]" value="Bulutangkis" @checked(!empty($Bulutangkis)) id="olahraga-2">
                        <label class="form-check-label" for="olahraga-2">
                            Bulutangkis
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="olahraga[]" value="Tenis" @checked(!empty($Tenis)) id="olahraga-3">
                        <label class="form-check-label" for="olahraga-3">
                            Tenis
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="olahraga[]" value="Berenang" @checked(!empty($Berenang)) id="olahraga-4">
                        <label class="form-check-label" for="olahraga-4">
                            Berenang
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="olahraga[]" value="Panjat Tebing" @checked(!empty($Panjat_Tebing)) id="olahraga-5">
                        <label class="form-check-label" for="olahraga-5">
                            Panjat Tebing
                        </label>
                      </div>
                    </div>
                  </fieldset>

                  <div class="mb-3">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" name="notification" @checked(!empty($notification)) value="on" id="switch-notification">
                      <label class="form-check-label" for="switch-notification">Nyalakan Notifikasi</label>
                    </div>
                  </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    @dump($allSessionData)
@endsection