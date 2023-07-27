@extends('template.main')

@section('content')
    <form action="" method="get">
        <fieldset>
            <legend>Form tabel percobaan_buat</legend>

            <label for="name">Nama: </label>
            <input type="text" name="nama" id="name" maxlength="100" required>
            <br><br>
            <label for="money">Uang: </label>
            <input type="number" name="uang" id="money" min="0" required>
            <br><br>
            <label for="state">Status: </label>
            <select name="status" id="state" required>
                <option value="Benar">Benar</option>
                <option value="Salah">Salah</option>
            </select>
            <br><br>
            <label for="npm">NPM: </label>
            <input type="text" name="npm" id="npm" size="9" maxlength="9" required>
            <br><br>
            <label for="ipk">IPK: </label>
            <input type="number" name="ipk" id="ipk" size="3" min="0" max="4" step="0.01" required>
            <br><br>

        </fieldset>
        <br>
        <button type="submit" name="btn" value="tambah">Kirim (Add)</button>
        <br><br>
        <button type="reset">Reset</button>
    </form>
    <ul>
        <li><a href="/formulir-percobaan-buat" title="Reset">Reset</a></li>
    </ul>

    @isset($status_query)
        <br>
        {{ $status_query }}
        @if ($status_query)
            <div class="php" style="background-color: aquamarine;">
                Berhasil Input
            </div>
        @else
            <div class="php" style="background-color: firebrick;">
                Berhasil Input
            </div>
        @endif
    @endisset

    <hr>

    <table>
        <tr>
            <th>List</th>
            <th>Nama</th>
            <th>Uang</th>
            <th>Status</th>
            <th>NPM</th>
            <th>IPK</th>
        </tr>
        @forelse ($list as $data)
            <tr>
                <td>{{ $data->list }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->uang }}</td>
                <td>{{ $data->status }}</td>
                <td>{{ $data->npm }}</td>
                <td>{{ $data->ipk }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Data Kosong</td>
            </tr>
        @endforelse
    </table>
@endsection