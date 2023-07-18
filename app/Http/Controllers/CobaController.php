<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/*
    Instead of defining all of your request handling logic as closures in your route files, you may wish to organize this
    behavior using "controller" classes. Controllers can group related request handling logic into a single class. For
    example, a UserController class might handle all incoming requests related to users, including showing, creating,
    updating, and deleting users. By default, controllers are stored in the app/Http/Controllers directory.

    Basic Controllers

    To quickly generate a new controller, you may run the make:controller Artisan command. By default, all of the
    controllers for your application are stored in the app/Http/Controllers directory

    -> php artisan make:controller UserController

    Let's take a look at an example of a basic controller. A controller may have any number of public methods which
    will respond to incoming HTTP requests

    Controllers are not required to extend a base class. However, you will not have access to convenient features
    such as the middleware and authorize methods.
*/

class CobaController extends Controller
{
    //

    public function coba_controller() {
        $data = [
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
        ];

        return View::make('coba', $data);
    }

    public function page1_controller() {
        $data = [
            'title' => 'Halaman Satu',
            // If you need to determine if a view exists, you may use the View facade. The exists method will return true if the view exists
            'cek_halaman_sebelah' => View::exists('belajarMembagi.page2')
        ];

        return view('belajarMembagi.page1', $data);
    }

    public function page2_controller() {
        $data = [
            'title' => 'Halaman Dua',
            'include_bootstrap' => false,
            'cek_halaman_sebelah' => View::exists('belajarMembagi.page1')
        ];

        return view('belajarMembagi.page2', $data);
    }

    public function halaman_coba_controller() {
        // Jika view ada semua maka akan dipilih index yang paling kecil
        return View::first(['firstView.b', 'firstView.a'], ['data' => 'Hello Apa Kabar !!!']);
    }

    public function halaman_a_controller() {
        /*
            As an alternative to passing a complete array of data to the view helper function, you may use the with method to
            add individual pieces of data to the view. The with method returns an instance of the view object so that you can
            continue chaining methods before returning the view
        */

        return View::make('firstView.a')
            ->with('data', 'Kamu lagi di halaman A')
            ->with('info', 'Data ini dikirim menggunakan method with()');
    }
}
