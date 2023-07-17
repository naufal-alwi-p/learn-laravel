<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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

/*
    Of course, it's not practical to return entire HTML documents strings directly from your routes and controllers.
    Thankfully, views provide a convenient way to place all of our HTML in separate files.

    Views separate your controller / application logic from your presentation logic and are stored in the resources/views
    directory. When using Laravel, view templates are usually written using the Blade templating language.

    Since this view is stored at resources/views/greeting.blade.php, we may return it using the global view helper like so
    You may create a view by placing a file with the .blade.php extension in your application's resources/views directory.
    The .blade.php extension informs the framework that the file contains a Blade template. Blade templates contain HTML
    as well as Blade directives that allow you to easily echo values, create "if" statements, iterate over data, and more.
*/

// Once you have created a view, you may return it from one of your application's routes or controllers using the global view helper:
Route::get('/', function () {
    return view('welcome');
});

// Views may also be returned using the View facade
Route::get('/coba', function() {
    return View::make('coba', [
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

/*
    As you can see, the first argument passed to the view helper corresponds to the name of the view file in the resources/views
    directory. The second argument is an array of data that should be made available to the view. In this case, we are passing
    the name variable, which is displayed in the view using Blade syntax.

    Views may also be nested within subdirectories of the resources/views directory. "Dot" notation may be used to reference
    nested views. For example, if your view is stored at resources/views/belajarMembagi/page1.blade.php, you may return it from one
    of your application's routes / controllers like so

    Note: View directory names should not contain the . character.
*/

Route::get('/page1', function() {
    return view('belajarMembagi.page1', [
        'title' => 'Halaman Satu',
        // If you need to determine if a view exists, you may use the View facade. The exists method will return true if the view exists
        'cek_halaman_sebelah' => View::exists('belajarMembagi.page2')
    ]);
});

Route::get('/page2', function() {
    return view('belajarMembagi.page2', [
        'title' => 'Halaman Dua',
        'include_bootstrap' => false,
        'cek_halaman_sebelah' => View::exists('belajarMembagi.page1')
    ]);
});

/*
    Using the View facade's first method, you may create the first view that exists in a given array of views. This may be
    useful if your application or package allows views to be customized or overwritten
*/

Route::get('/halaman_coba', function() {
    // Jika view ada semua maka akan dipilih index yang paling kecil
    return View::first(['firstView.b', 'firstView.a'], ['data' => 'Hello Apa Kabar !!!']);
});

/*
    As you saw in the previous examples, you may pass an array of data to views to make that data available to the view

    When passing information in this manner, the data should be an array with key / value pairs. After providing data to
    a view, you can then access each value within your view using the data's keys, such as <?php echo $name; ?>.

    As an alternative to passing a complete array of data to the view helper function, you may use the with method to
    add individual pieces of data to the view. The with method returns an instance of the view object so that you can
    continue chaining methods before returning the view
*/

Route::get('halaman_a', function() {
    return View::make('firstView.a')
        ->with('data', 'Kamu lagi di halaman A')
        ->with('info', 'Data ini dikirim menggunakan method with()');
});

/*
    Sharing Data With All Views
    
    Occasionally, you may need to share data with all views that are rendered by your application. You may do so using the
    View facade's share method. Typically, you should place calls to the share method within a service provider's boot method.
    You are free to add them to the App\Providers\AppServiceProvider class or generate a separate service provider to house them
*/

/*
    Optimizing Views

    By default, Blade template views are compiled on demand. When a request is executed that renders a view, Laravel will
    determine if a compiled version of the view exists. If the file exists, Laravel will then determine if the uncompiled
    view has been modified more recently than the compiled view. If the compiled view either does not exist, or the
    uncompiled view has been modified, Laravel will recompile the view.

    Compiling views during the request may have a small negative impact on performance, so Laravel provides the view:cache
    Artisan command to precompile all of the views utilized by your application. For increased performance, you may wish
    to run this command as part of your deployment process:

    -> php artisan view:cache

    You may use the view:clear command to clear the view cache:

    -> php artisan view:clear
*/

Route::get('/cek_section', function() {
    return View::make('sectionCheck.cekSection');
});
