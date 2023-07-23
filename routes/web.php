<?php

use App\Http\Controllers\CobaController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\SectionCheckController;
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
Route::get('/coba', [CobaController::class, 'coba_controller']);

/*
    As you can see, the first argument passed to the view helper corresponds to the name of the view file in the resources/views
    directory. The second argument is an array of data that should be made available to the view. In this case, we are passing
    the name variable, which is displayed in the view using Blade syntax.

    Views may also be nested within subdirectories of the resources/views directory. "Dot" notation may be used to reference
    nested views. For example, if your view is stored at resources/views/belajarMembagi/page1.blade.php, you may return it from one
    of your application's routes / controllers like so

    Note: View directory names should not contain the . character.

    If you need to determine if a view exists, you may use the View facade. The exists method will return true if the view exists
*/

/*
    Once you have written a controller class and method, you may define a route to the controller method like so

    When an incoming request matches the specified route URI, the page1_controller method on the
    App\Http\Controllers\CobaController class will be invoked and the route parameters will be passed to the method.
*/
Route::get('/page1', [CobaController::class, 'page1_controller']);

Route::get('/page2', [CobaController::class, 'page2_controller']);

/*
    Using the View facade's first method, you may create the first view that exists in a given array of views. This may be
    useful if your application or package allows views to be customized or overwritten

    Jika view ada semua maka akan dipilih index yang paling kecil
*/

Route::get('/halaman_coba', [CobaController::class, 'halaman_coba_controller']);

/*
    As you saw in the previous examples, you may pass an array of data to views to make that data available to the view

    When passing information in this manner, the data should be an array with key / value pairs. After providing data to
    a view, you can then access each value within your view using the data's keys, such as <?php echo $name; ?>.

    As an alternative to passing a complete array of data to the view helper function, you may use the with method to
    add individual pieces of data to the view. The with method returns an instance of the view object so that you can
    continue chaining methods before returning the view
*/

Route::get('halaman_a', [CobaController::class, 'halaman_a_controller']);

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

/*
    When registering routes for single action controllers, you do not need to specify a controller method. Instead, you may
    simply pass the name of the controller to the router
*/
Route::get('/cek_section', SectionCheckController::class);

/*
    Basic Routing

    The most basic Laravel routes accept a URI and a closure, providing a very simple and expressive method of defining routes
    and behavior without complicated routing configuration files
*/
Route::get('/tes', function() {
    return 'Halo, Apa kabar ?!';
});

/*
    The Default Route Files

    All Laravel routes are defined in your route files, which are located in the routes directory. These files are automatically
    loaded by your application's App\Providers\RouteServiceProvider. The routes/web.php file defines routes that are for your
    web interface. These routes are assigned the web middleware group, which provides features like session state and CSRF
    protection. The routes in routes/api.php are stateless and are assigned the api middleware group.

    For most applications, you will begin by defining routes in your routes/web.php file. The routes defined in routes/web.php
    may be accessed by entering the defined route's URL in your browser.

    Routes defined in the routes/api.php file are nested within a route group by the RouteServiceProvider. Within this
    group, the /api URI prefix is automatically applied so you do not need to manually apply it to every route in the
    file. You may modify the prefix and other route group options by modifying your RouteServiceProvider class.

    Available Router Methods

    The router allows you to register routes that respond to any HTTP verb:
    - Route::get($uri, $callback);
    - Route::post($uri, $callback);
    - Route::put($uri, $callback);
    - Route::patch($uri, $callback);
    - Route::delete($uri, $callback);
    - Route::options($uri, $callback);

    Sometimes you may need to register a route that responds to multiple HTTP verbs. You may do so using the match method.
    Or, you may even register a route that responds to all HTTP verbs using the any method:
    Route::match(['get', 'post'], '/', function () {
        // Your Code ...
    });
    
    Route::any('/', function () {
        // Your Code ...
    });


    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    Note: When defining multiple routes that share the same URI, routes using the get, post, put, patch, delete, and options
    methods should be defined before routes using the any, match, and redirect methods. This ensures the incoming request
    is matched with the correct route.
    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*/

/*
    Dependency Injection

    You may type-hint any dependencies required by your route in your route's callback signature. The declared dependencies will
    automatically be resolved and injected into the callback by the Laravel service container. For example, you may type-hint
    the Illuminate\Http\Request class to have the current HTTP request automatically injected into your route callback
*/

Route::get('/injeksi_dependensi', [CobaController::class, 'injeksi_dependensi_controller']);

/*
    Redirect Routes

    If you are defining a route that redirects to another URI, you may use the Route::redirect method. This method provides
    a convenient shortcut so that you do not have to define a full route or controller for performing a simple redirect
*/

Route::redirect('/dependency_injection', '/injeksi_dependensi');

/*
    By default, Route::redirect returns a 302 status code. You may customize the status code using the optional third parameter

    Route::redirect('/here', '/there', 301);

    Or, you may use the Route::permanentRedirect method to return a 301 status code

    Route::permanentRedirect('/here', '/there');

    Warning: When using route parameters in redirect routes, the following parameters are reserved by Laravel and cannot be
    used: destination and status.
*/

/*
    View Routes

    If your route only needs to return a view, you may use the Route::view method. Like the redirect method, this method provides
    a simple shortcut so that you do not have to define a full route or controller. The view method accepts a URI as its first
    argument and a view name as its second argument. In addition, you may provide an array of data to pass to the view as an
    optional third argument

    Warning: When using route parameters in view routes, the following parameters are reserved by Laravel and cannot be
    used: view, data, status, and headers.
*/

Route::view('/see_page', 'learn.see_page', ['title' => 'Memahami Route::view()', 'data' => 'Halo! Selamat Datang']);

/*
    Route Parameters

    Required Parameters

    Sometimes you will need to capture segments of the URI within your route. For example, you may need to capture a user's ID
    from the URL. You may do so by defining route parameters

    You may define as many route parameters as required by your route
*/

Route::get('/user/{id}/{menu}', [CobaController::class, 'user_controller']);

/*
    Route parameters are always encased within {} braces and should consist of alphabetic characters. Underscores (_) are
    also acceptable within route parameter names. Route parameters are injected into route callbacks / controllers based
    on their order - the names of the route callback / controller arguments do not matter.

    Parameters & Dependency Injection

    If your route has dependencies that you would like the Laravel service container to automatically inject into your route's
    callback, you should list your route parameters after your dependencies
*/

/*
    Optional Parameters

    Occasionally you may need to specify a route parameter that may not always be present in the URI. You may do so by placing
    a ? mark after the parameter name. Make sure to give the route's corresponding variable a default value
*/

Route::get('/cart/{data?}/{status?}', [CobaController::class, 'cart_controller'])->whereAlpha('data')->whereNumber('status');

/*
    Regular Expression Constraints

    You may constrain the format of your route parameters using the where method on a route instance. The where method accepts
    the name of the parameter and a regular expression defining how the parameter should be constrained

    For convenience, some commonly used regular expression patterns have helper methods that allow you to quickly add pattern
    constraints to your routes

    If the incoming request does not match the route pattern constraints, a 404 HTTP response will be returned.
*/

/*
    Named Routes

    Named routes allow the convenient generation of URLs or redirects for specific routes. You may specify a name for a route
    by chaining the name method onto the route definition

    You may also specify route names for controller actions

    Route names should always be unique.
*/

Route::get('/big_brain/{info?}', [CobaController::class, 'big_brain_controller'])->name('senku');

/*
    Route Groups

    Route groups allow you to share route attributes, such as middleware, across a large number of routes without needing to
    define those attributes on each individual route.

    Nested groups attempt to intelligently "merge" attributes with their parent group. Middleware and where conditions are merged
    while names and prefixes are appended. Namespace delimiters and slashes in URI prefixes are automatically added where appropriate.

    If a group of routes all utilize the same controller, you may use the controller method to define the common controller for all
    of the routes within the group. Then, when defining the routes, you only need to provide the controller method that they invoke
*/

Route::controller(CobaController::class)->group(function() {
    Route::get('/coba_lagi1', 'coba_lagi1_controller');

    Route::get('/coba_lagi2', 'coba_lagi2_controller');
});

/*
    Route Prefixes

    The prefix method may be used to prefix each route in the group with a given URI. For example, you may want to prefix all route
    URIs within the group with admin
*/

Route::prefix('buku')->group(function() {
    Route::get('/tulis', [CobaController::class, 'tulis_controller']); // "/buku/tulis"

    Route::get('/paket', [CobaController::class, 'paket_controller']); // "/buku/paket"
});

/*
    Route Name Prefixes

    The name method may be used to prefix each route name in the group with a given string. For example, you may want to prefix
    the names of all of the routes in the group with admin. The given string is prefixed to the route name exactly as it is
    specified, so we will be sure to provide the trailing . character in the prefix
*/

Route::name('teknik_')->group(function() {
    Route::get('/teori', [CobaController::class, 'teori_controller'])->name('theory'); // "teknik_theory"

    Route::get('/praktek', [CobaController::class, 'praktek_controller'])->name('practice'); // "teknik_praktek"
});

/*
    Fallback Routes

    Using the Route::fallback method, you may define a route that will be executed when no other route matches the incoming request.
    Typically, unhandled requests will automatically render a "404" page via your application's exception handler. However, since
    you would typically define the fallback route within your routes/web.php file, all middleware in the web middleware group will
    apply to the route. You are free to add additional middleware to this route as needed

    Warning: The fallback route should always be the last route registered by your application.
*/

// Route::fallback(function() {
//     return view('error', ['title' => 'Error Page']);
// });

Route::get('/belajar_collection', [CollectionController::class, 'belajar_collection_controller'])->name('collect');

Route::get('/php_info', [CobaController::class, 'php_info_controller']);
