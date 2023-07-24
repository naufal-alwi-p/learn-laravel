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

    public function injeksi_dependensi_controller(Request $request) {
        /*
            Dependency Injection

            You may type-hint any dependencies required by your route in your route's callback signature. The declared dependencies will
            automatically be resolved and injected into the callback by the Laravel service container. For example, you may type-hint
            the Illuminate\Http\Request class to have the current HTTP request automatically injected into your route callback
        */

        $data = [
            'title' => 'Belajar Dependency Injection',
            'info_request_http' => [
                'path' => $request->path(),
                'url' => $request->url(),
                'fullUrl' => $request->fullUrl(),
                'host' => $request->host(),
                'httpHost' => $request->httpHost(),
                'schemeAndHttpHost' => $request->schemeAndHttpHost(),
                'method' => $request->method(),
                'ip' => $request->ip()
            ]
        ];

        return View::make('learn.injeksi_dependensi', $data);
    }

    /*
        If your route has dependencies that you would like the Laravel service container to automatically inject into your route's
        callback, you should list your route parameters after your dependencies
    */

    public function user_controller(Request $request, int $aidi, string $minu) {
        $data = [
            'title' => 'Belajar Route Parameter',
            'id' => $aidi,
            'menu' => $minu,
            'func' => __FUNCTION__,
            'info_request_http' => [
                'path' => $request->path(),
                'url' => $request->url(),
                'fullUrl' => $request->fullUrl(),
                'host' => $request->host(),
                'httpHost' => $request->httpHost(),
                'schemeAndHttpHost' => $request->schemeAndHttpHost(),
                'method' => $request->method(),
                'ip' => $request->ip()
            ]
        ];

        return view('learn.user', $data);
    }

    public function cart_controller(string $data = null, int $status = 0) {
        $data = [
            'title' => 'Optional Parameter',
            'data' => $data,
            'status' => $status
        ];

        return view('learn.cart', $data);
    }

    public function big_brain_controller(Request $request, $info = null) {
        $data = [
            'title' => 'Named Route',
            /*
                Generating URLs To Named Routes

                Once you have assigned a name to a given route, you may use the route's name when generating URLs or redirects
                via Laravel's route and redirect helper functions

                If the named route defines parameters, you may pass the parameters as the second argument to the route function.
                The given parameters will automatically be inserted into the generated URL in their correct positions

                If you pass additional parameters in the array, those key / value pairs will automatically be added to the
                generated URL's query string

                Sometimes, you may wish to specify request-wide default values for URL parameters, such as the current locale.
                To accomplish this, you may use the URL::defaults method.
            */
            'generate' => route('senku', ['info' => 'kopi']),
            'data' => $info,
            /*
                Inspecting The Current Route

                If you would like to determine if the current request was routed to a given named route, you may use the named
                method on a Route instance. For example, you may check the current route name from a route middleware
            */
            'named_route' => $request->route()->getName(),
            'check_named_route' => $request->route()->named('senku')
        ];
        return view('learn.big_brain', $data);
    }

    public function coba_lagi1_controller() {
        $data = ['title' => 'Route Groups'];

        return View::make('learn.coba_lagi1', $data);
    }

    public function coba_lagi2_controller() {
        $data = ['title' => 'Route Groups'];

        return View::make('learn.coba_lagi2', $data);
    }

    public function tulis_controller() {
        $data = ['title' => 'Prefix Group'];

        return view('learn.tulis', $data);
    }

    public function paket_controller() {
        $data = ['title' => 'Prefix Group'];

        return view('learn.paket', $data);
    }

    public function teori_controller() {
        $data = [
            'title' => 'Route Name Prefix Group',
            'generate' => route('teknik_theory')
        ];

        return view('learn.teori', $data);
    }

    public function praktek_controller() {
        $data = [
            'title' => 'Route Name Prefix Group',
            'generate' => route('teknik_practice')
        ];

        return view('learn.praktek', $data);
    }

    public function php_info_controller() {
        return phpinfo();
    }

    public function formulir_controller(Request $request) {
        $data = [
            'title' => 'Formulir',
            'semua' => $request->all()
        ];

        return view('form.form1', $data);
    }
}
