@extends('template.main')

@section('content')
    <h2>Introduction</h2>

    <p>
        The Illuminate\Support\Collection class provides a fluent, convenient wrapper for working with arrays of data. For
        example, check out the following code. We'll use the collect helper to create a new collection instance from the array,
        run the strtoupper function on each element, and then remove all empty elements:
    </p>
<pre>
    $collection = collect(['taylor', 'abigail', null])->map(function (string $name) {
        return strtoupper($name);
    })->reject(function (string $name) {
        return empty($name);
    });
</pre>
    <p>
        As you can see, the Collection class allows you to chain its methods to perform fluent mapping and reducing of the
        underlying array. In general, collections are immutable, meaning every Collection method returns an entirely new
        Collection instance.
    </p>

    <h2>Creating Collections</h2>

    <p>
        As mentioned above, the collect helper returns a new Illuminate\Support\Collection instance for the given array. So,
        creating a collection is as simple as:
    </p>
<pre>
    $collection = collect([1, 2, 3]);
</pre>
    <p>
        Info: The results of Eloquent queries are always returned as Collection instances.
    </p>

    <div class="php">
        <p>
            Collection milik Laravel dapat langsung ditampilkan dengan perintah "echo" milik php, sedangkan Array biasa tidak bisa
        </p>

        <p>
            Isi Collection $koleksi1 = {{ $koleksi1 }}
        </p>
    </div>

    <h2>Available Methods</h2>
    <p>
        We'll discuss each method available on the Collection class. Remember, all of these methods may be chained to fluently
        manipulate the underlying array. Furthermore, almost every method returns a new Collection instance, allowing you to
        preserve the original copy of the collection when necessary:
    </p>

    <h3>1. all()</h3>
    <div class="php">
        <p>
            all() method akan mengembalikan isinya ke dalam bentuk array biasa
        </p>
        @php
            $arr = $koleksi2->all();
        @endphp
        {{ gettype($koleksi2) }}
        <br>
        {{ gettype($arr) }}

        <br><br>

        Isi $koleksi2 = {{ $koleksi2 }}

        @php
            var_dump($arr)
        @endphp
    </div>

    <h3>2. avg() / average()</h3>
    <div class="php">
        <p>
            The avg method returns the average value of a given key
        </p>
        @php
            $aver1 = $koleksi3->average();

            $aver2 = $koleksi4->average(function($val) {
                if(is_numeric($val)) {
                    return $val;
                }
            });
        @endphp

        $kelompok3 = {{ $koleksi3 }}
        <br>
        $aver1 = {{ $aver1 }}
        <br><br>
        $kelompok4 = {{ $koleksi4 }}
        <br>
        $aver2 = {{ $aver2 }}
    </div>

    <h3>3. chunk()</h3>
    <div class="php">
        <p>
            The chunk method breaks the collection into multiple, smaller collections of a given size
        </p>
        @php
            $chunkCollect = $koleksi3->chunk(3);
        @endphp
        $koleksi3 = {{ $koleksi3 }}
        <br>
        $chunkCollect = {{ $chunkCollect }}
        @php
            var_dump($chunkCollect->all());
        @endphp
    </div>

    <h3>4. chunkWhile()</h3>
    <div class="php">
        <p>
            The chunkWhile method breaks the collection into multiple, smaller collections based on the evaluation of the given
            callback. The $chunk variable passed to the closure may be used to inspect the previous element:
        </p>
        @php
            $chunkJika = $koleksi5->chunkWhile(function($value, $key, $bCollect) {
                if($value < 50) {
                    return true;
                }
            });
        @endphp
        $koleksi5 = {{ $koleksi5 }}
        <br>
        $chunkJika = {{ $chunkJika }}
    </div>

    <h3>5. collapse()</h3>
    <div class="php">
        <p>
            The collapse method collapses a collection of arrays into a single, flat collection
        </p>
        <p>
            Dari array 2 dimesi ke 1 dimensi, misal ada dimensi ke-3 dia turun jadi dimensi ke dua
        </p>
        @php
            $gabung = $koleksi6->collapse();
            $gabung2 = $gabung->collapse();
        @endphp
        $koleksi6 = {{ $koleksi6 }}
        <br>
        $gabung = {{ $gabung }}
        <br>
        $gabung2 = {{ $gabung2 }}

        <p>
            Pahami Perilaku diatas.
        </p>
    </div>

    <h3>6. collect()</h3>
    <div class="php">
        <p>
            The collect method returns a new Collection instance with the items currently in the collection
        </p>
        <p>
            The collect method is primarily useful for converting lazy collections into standard Collection instances
        </p>
        <p>
            The collect method is especially useful when you have an instance of Enumerable and need a non-lazy collection instance. Since collect() is part of the Enumerable contract, you can safely use it to get a Collection instance.
        </p>
        @php
            $koleksiBaru = $koleksi2->collect();
        @endphp

        $koleksi2 = {{ $koleksi2 }}
        <br>
        $koleksiBaru = {{ $koleksiBaru }}
    </div>

    <h3>7. combine()</h3>
    <div class="php">
        <p>
            The combine method combines the values of the collection, as keys, with the values of another array or collection
        </p>

        @php
            $koleksiBaru2 = $koleksi2->combine(['Benar', 32, "Yeay", 100]);
        @endphp

        $koleksi2 = {{ $koleksi2 }}
        <br>
        $koleksiBaru2 = {{ $koleksiBaru2 }}
    </div>

    <h2>Testing</h2>
    <div class="php">
        @php
            $tes = $koleksi10->zip(['Nasi', 'Padang']);
        @endphp
        Sebelum: {{ $koleksi10 }}
        <br><br>
        Sesudah: {{ $tes }}
    </div>
@endsection