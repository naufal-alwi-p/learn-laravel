@extends('template.main')

@section('content')
    <form action="" method="get">
        <fieldset>
            <legend>Form tabel data_diri</legend>

            <label for="name">Nama: </label>
            <input type="text" name="nama" id="name" maxlength="100" required>
            <br><br>
            <label for="birthday">Tanggal Lahir: </label>
            <input type="date" name="lahir" id="birthday" required>
            <br><br>
            <label for="year">Tahun Masuk: </label>
            <input type="number" name="tahun_masuk" id="year" min="1970" max="{{ date('Y') }}" required>

        </fieldset>
        <br>
        <button type="submit" name="btn" value="tambah">Kirim (Add)</button>
        <br><br>
        <button type="reset">Reset</button>
    </form>
    <ul>
        <li><a href="/formulir-data-diri" title="Reset">Reset</a></li>
    </ul>

    @isset($status_query)
        <br>
        @if ($status_query)
            <div class="php" style="background-color: aquamarine;">
                Berhasil Input
            </div>
        @else
            <div class="php" style="background-color: firebrick;">
                Gagal Input
            </div>
        @endif
    @endisset

    <hr>

    <table>
        <tr>
            <th>id</th>
            <th>Nama</th>
            <th>Tanggal Lahir</th>
            <th>Tahun Masuk</th>
        </tr>
        @forelse ($list as $data)
            <tr>
                <td>{{ $data->id }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->tanggal_lahir }}</td>
                <td>{{ $data->tahun_masuk }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Data Kosong</td>
            </tr>
        @endforelse
    </table>
    
@endsection