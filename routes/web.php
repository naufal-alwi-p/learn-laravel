<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/coba', function() {
    return view('coba', [
        'nama' => 'Randi',
        'ada_html1' => '<b>HTML ini otomatis di-escape oleh Laravel</b>',
        'ada_html2' => '<b>tag b HTML ini akan dibaca oleh browser</b>',
        'data_json' => [
            'nama' => 'Naufal A.P',
            'umur' => 19,
            'mahasiswa' => true,
            'tinggi' => 170.2
        ],
        'data' => [1, 2, 3, 4, 'Randi', 5, 6, 7],
        'kosong' => 0,
        'arr_kosong' => [],
        'arr_bersarang' => [[], ["Nasi", "Pagi", "Tahu"], ["Padi", "Siang", "Rendang"], ["Ayam Goreng", "Cincau", "Tahu"], ["Soto Ayam", "Sop Buah", "Jus Alpukat"]]
    ]);
});
