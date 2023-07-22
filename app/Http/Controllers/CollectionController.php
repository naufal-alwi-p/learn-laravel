<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CollectionController extends Controller
{
    //
    public function belajar_collection_controller() {
        $array1 = [12, "Belajar", 73.6, true];
        $array2 = ["Selamat Pagi", 2754, null, false, 327.5];
        $arrAngka = [12, 54, 65, 43, 74, 23];
        $arrFloat = [34.6, 44.1, 65.4, 73.2];
        $arrAssos = [
            'satu' => 2,
            'dua' => 2,
            'tiga' => '17'
        ];
        $arrMulti = [
            132,
            [12, 645, "Tahu", 43.7, 91, ['Nasi', 7]],
            ["tahu", 'bulat', 100, 65.3],
            [["hai", 13], 43, [12, 'Nasi', 65.4]]
        ];
        $arrKembar = [['a', 'b'], ['a', 'c', 'a']];

        $data = ['title' => 'Belajar Collection'];

        $data['koleksi1'] = collect($array2);

        $data['koleksi2'] = collect($array1);

        $data['koleksi3'] = collect($arrAngka);

        $data['koleksi4'] = collect($arrAssos);

        $data['koleksi5'] = collect($arrFloat);

        $data['koleksi6'] = collect($arrMulti);

        $data['koleksi7'] = Collection::make($arrKembar);

        $data['koleksi8'] = Collection::times(5, function($angka) {
            return 'Angka Ke-' . $angka;
        });

        $data['koleksi9'] = Collection::unwrap(collect($arrAngka));

        $data['koleksi10'] = Collection::wrap('Hai');

        return view('learn_collection.collection', $data);
    }
}
