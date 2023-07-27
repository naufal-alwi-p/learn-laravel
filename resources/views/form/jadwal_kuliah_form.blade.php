@extends('template.main')

@section('content')
    <form action="" method="get">
        <fieldset>
            <legend>Formulir Jadwal Kuliah</legend>

            <label for="code">Kode: </label>
            <input type="text" name="kode" id="code" maxlength="9" required>
            <br><br>
            <label for="mata">Mata Kuliah: </label>
            <input type="text" name="mata_kuliah" id="mata" required>
            <br><br>
            <label for="sks">SKS: </label>
            <input type="number" name="sks" id="sks" min="1" max="5" required>
        </fieldset>
        <br>
        <button type="submit" name="btn" value="tambah">Kirim Add</button>
        <br><br>
        <button type="reset">Reset</button>
    </form>
    <ul>
        <li><a href="/formulir-jadwal-kuliah">Reset</a></li>
    </ul>

    <hr>

    @isset($status_query)
        @if ($status_query)
            <div class="php" style="background-color: aquamarine;">
                Berhasil Diinput
            </div>
        @else
            <div class="php" style="background-color: firebrick;">
                Gagal Diinput
            </div>
        @endif
        <br>
    @endisset

    <table>
        <tr>
            <th>Kode</th>
            <th>Mata Kuliah</th>
            <th>SKS</th>
        </tr>
        @forelse ($list->all() as $data)
            <tr>
                <td>{{ $data->kode }}</td>
                <td>{{ $data->mata_kuliah }}</td>
                <td>{{ $data->sks }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3"><i>Data Kosong</i></td>
            </tr>
        @endforelse
    </table>
@endsection