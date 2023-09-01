@extends('template.main')

@section('content')
    <h1 class="mt-5">{{ $title }}</h1>

    <a class="btn btn-primary mb-3" href="/belajar-laravel" role="button"><i class="bi bi-house-door-fill"></i> Belajar Laravel</a>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-5">
        <div class="card-body">
            <form method="post" autocomplete="off">
                @csrf
                <div class="mb-3 input-group">
                    <label for="name-input" class="input-group-text">Name:</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" id="name-input" class="form-control">
                </div>
                <div class="mb-3 input-group">
                    <label for="username-input" class="input-group-text">Username:</label>
                    <input type="text" name="username" value="{{ old('username') }}" id="username-input" class="form-control">
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <label for="email-input" class="input-group-text">Email:</label>
                        <input type="email" name="email" value="{{ old('email') }}" id="email-input" class="form-control">
                    </div>
                    <div class="form-text">example@email.com</div>
                </div>
                <div class="mb-3 input-group">
                    <label for="password-input" class="input-group-text">Password:</label>
                    <input type="password" name="pw" value="{{ old('pw') }}" id="password-input" class="form-control">
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <div class="form-floating">
                            <select name="opsi" id="option-input" class="form-select">
                                <option value="login" @selected(old('opsi') === 'login')>Login</option>
                                <option value="new_account" @selected(old('opsi') === 'new_account')>Create New Account</option>
                                <option value="check_rehash" @selected(old('opsi') === 'check_rehash')>Check Rehash</option>
                                <option value="rehash" @selected(old('opsi') === 'rehash')>Rehash</option>
                                <option value="info" @selected(old('opsi') === 'info')>Info</option>
                            </select>
                            <label for="option-input">Option</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-floating">
                            <select name="work_factor" id="work-input" class="form-select">
                                <option value="10" @selected(old('work_factor') === '10')>10</option>
                                <option value="11" @selected(old('work_factor') === '11')>11</option>
                                <option value="12" @selected(old('work_factor') === '12')>12</option>
                                <option value="13" @selected(old('work_factor') === '13')>13</option>
                                <option value="14" @selected(old('work_factor') === '14')>14</option>
                                <option value="15" @selected(old('work_factor') === '15')>15</option>
                                <option value="16" @selected(old('work_factor') === '16')>16</option>
                                <option value="17" @selected(old('work_factor') === '17')>17</option>
                                <option value="18" @selected(old('work_factor') === '18')>18</option>
                                <option value="19" @selected(old('work_factor') === '19')>19</option>
                                <option value="20" @selected(old('work_factor') === '20')>20</option>
                            </select>
                            <label for="work-input">Work Factors</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    @if (session('info'))
        @dump(session('info'))
    @endif
@endsection