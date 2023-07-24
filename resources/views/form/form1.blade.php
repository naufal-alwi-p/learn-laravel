@extends('template.main')

@section('content')
    <form action="" method="get" autocomplete="off">
        <label for="teks">Teks: </label>
        <input type="text" name="text" id="teks">
        <br>
        <button type="submit">Kirim</button>
    </form>

    @isset($semua)
        @dump($semua)
    @endisset
@endsection