<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class ResponseLearnController extends Controller
{
    public function response_index_controller() {
        $listRoute = collect(Route::getRoutes()->getRoutesByMethod()["GET"]);

        $data = [
            'title' => 'Daftar Isi Belajar Response Laravel',
            'links' => $listRoute->filter(fn($route) => ($route->getPrefix() === 'belajar-laravel/response'))->values()->all()
        ];

        return view('belajar.index_2', $data);
    }

    public function response_string_controller(Request $request) {
        /*
            All routes and controllers should return a response to be sent back to the user's browser. Laravel provides several
            different ways to return responses. The most basic response is returning a string from a route or controller.
            The framework will automatically convert the string into a full HTTP response:
        */
        return 'Halo, selamat datang di ' . $request->getUri();

    }

    public function response_array_controller() {
        /*
            In addition to returning strings from your routes and controllers, you may also return arrays. The framework will
            automatically convert the array into a JSON response:
        */
        return [12, "Tahu", 12.5, "Minuman" => "Jus Alpukat"];;
    }

    public function response_eloquent_controller() {
        /*
            Did you know you can also return Eloquent collections from your routes or controllers? They will automatically be
            converted to JSON. Give it a shot!

            You may return Eloquent ORM models and collections directly from your routes and controllers. When you do, Laravel
            will automatically convert the models and collections to JSON responses while respecting the model's hidden attributes:
        */
        return Category::all();
    }

    /*
        Typically, you won't just be returning simple strings or arrays from your route actions. Instead, you will be returning
        full Illuminate\Http\Response instances or views.
    */

    public function response_object_controller() {
        /*
            Returning a full Response instance allows you to customize the response's HTTP status code and headers. A Response
            instance inherits from the Symfony\Component\HttpFoundation\Response class, which provides a variety of methods
            for building HTTP responses

            Keep in mind that most response methods are chainable, allowing for the fluent construction of response instances.
            For example, you may use the header method to add a series of headers to the response before sending it back to the user

            Or, you may use the withHeaders method to specify an array of headers to be added to the response
        */
        return response('Ini dikembalikan melalui object response', 200)->header('Content-Type', 'text/plain');

        // Bisa juga ditulis dengan
        // return response('Ini dikembalikan melalui object response', 200, ['Content-Type' => 'text/plain']);
        // return response('Ini dikembalikan melalui object response', 200)->withHeaders(['Content-Type' => 'text/plain']);
    }

    public function response_set_cookie_controller(Request $request) {
        /*
            If you would like to ensure that a cookie is sent with the outgoing response but you do not yet have an instance
            of that response, you can use the Cookie facade to "queue" cookies for attachment to the response when it is sent.
            The queue method accepts the arguments needed to create a cookie instance. These cookies will be attached to the
            outgoing response before it is sent to the browser
        */
        if($request->cookie('tes-cookie2') !== 'Soto Lamongan') {
            Cookie::queue('tes-cookie2', 'Soto Lamongan', 25);
        }

        /*
            If you would like to generate a Symfony\Component\HttpFoundation\Cookie instance that can be attached to a response
            instance at a later time, you may use the global cookie helper. This cookie will not be sent back to the client
            unless it is attached to a response instance
        */
        if($request->cookie('tes-cookie3') !== 'Bubur Kacang Ijo') {
            $cookie3 = cookie('tes-cookie3', 'Bubur Kacang Ijo', 20);
        }

        /*
            You may attach a cookie to an outgoing Illuminate\Http\Response instance using the cookie method. You should pass
            the name, value, and the number of minutes the cookie should be considered valid to this method
            
            return response('Hello World')->cookie('name', 'value', $minutes);

            The cookie method also accepts a few more arguments which are used less frequently. Generally, these arguments
            have the same purpose and meaning as the arguments that would be given to PHP's native setcookie method
            
            return response('Hello World')->cookie('name', 'value', $minutes, $path, $domain, $secure, $httpOnly);
        */
        $respon = response($request->cookie());

        if($request->cookie('tes-cookie') !== 'Tahu Sumedang') {
            $respon->cookie('tes-cookie', 'Tahu Sumedang', 30, '/', '127.0.0.1', true, true);
        }

        if(isset($cookie3)) {
            $respon->cookie($cookie3);
        }

        return $respon;
    }

    public function response_delete_cookie_controller(Request $request) {
        /*
            If you do not yet have an instance of the outgoing response, you may use the Cookie facade's expire method to expire a cookie
        */
        if($request->hasCookie('tes-cookie2')) {
            Cookie::expire('tes-cookie2');
        }
        /*
            You may remove a cookie by expiring it via the withoutCookie method of an outgoing response
        */
        $respon = response($request->cookie());

        if($request->hasCookie('tes-cookie')) {
            $respon->withoutCookie('tes-cookie');
        }

        if($request->hasCookie('tes-cookie3')) {
            $respon->withoutCookie('tes-cookie3');
        }

        return $respon;

        /*
            By default, all cookies generated by Laravel are encrypted and signed so that they can't be modified or read by the client.
            If you would like to disable encryption for a subset of cookies generated by your application, you may use the $except
            property of the App\Http\Middleware\EncryptCookies middleware, which is located in the app/Http/Middleware directory
        */
    }

    public function redirect_response_controller() {
        /*
            Redirect responses are instances of the Illuminate\Http\RedirectResponse class, and contain the proper headers needed to
            redirect the user to another URL. There are several ways to generate a RedirectResponse instance. The simplest method
            is to use the global redirect helper
        */

        return redirect('/belajar-laravel');
    }

    public function redirect_to_named_route() {
        /*
            When you call the redirect helper with no parameters, an instance of Illuminate\Routing\Redirector is returned, allowing
            you to call any method on the Redirector instance. For example, to generate a RedirectResponse to a named route, you may
            use the route method

            If your route has parameters, you may pass them as the second argument to the route method

            If you are redirecting to a route with an "ID" parameter that is being populated from an Eloquent model, you may pass
            the model itself. The ID will be extracted automatically

            If you would like to customize the value that is placed in the route parameter, you can specify the column in the route
            parameter definition (/profile/{id:slug}) or you can override the getRouteKey method on your Eloquent model
        */
        return redirect()->route('homepage');
    }

    public function redirect_to_controller_action() {
        /*
            You may also generate redirects to controller actions. To do so, pass the controller and action name to the action method

            If your controller route requires parameters, you may pass them as the second argument to the action method
        */
        return redirect()->action([$this::class, 'target_redirect_controller']);
    }

    public function target_redirect_controller() {
        // Ini target redirect

        return 'Halo';
    }

    public function redirect_to_external_domain_controller() {
        /*
            Sometimes you may need to redirect to a domain outside of your application. You may do so by calling the away
            method, which creates a RedirectResponse without any additional URL encoding, validation, or verification
        */

        return redirect()->away('https://naufaldev.my.id');
    }

    /*
        The response helper may be used to generate other types of response instances. When the response helper is called
        without arguments, an implementation of the Illuminate\Contracts\Routing\ResponseFactory contract is returned.
        This contract provides several helpful methods for generating responses.
    */

    public function form_get_method_controller() {
        $data = [
            'title' => 'Form Data'
        ];

        /*
            If you need control over the response's status and headers but also need to return a view as the response's
            content, you should use the view method
        */
        // return response()->view('belajar.response.form', $data);

        /*
            Of course, if you do not need to pass a custom HTTP status code or custom headers, you may use the global
            view helper function.
        */
        return view('belajar.response.form', $data);
    }

    public function form_post_method_controller(Request $request) {
        if($request->input('pw') !== "bakso") {
            /*
                Sometimes you may wish to redirect the user to their previous location, such as when a submitted form is invalid.
                You may do so by using the global back helper function. Since this feature utilizes the session, make sure the
                route calling the back function is using the web middleware group (Lihat withInput() method)

                You may use the withInput method provided by the RedirectResponse instance to flash the current request's input
                data to the session before redirecting the user to a new location. This is typically done if the user has
                encountered a validation error. Once the input has been flashed to the session, you may easily retrieve it
                during the next request to repopulate the form
            */

            /*
                Redirecting to a new URL and flashing data to the session are usually done at the same time. Typically, this is
                done after successfully performing an action when you flash a success message to the session. For convenience, you
                may create a RedirectResponse instance and flash data to the session in a single, fluent method chain (Lihat with() method)
            */
            $request->flashExcept('pw'); // Fungsinya sama dengan yang dibawah V
            return back()->with('gagal', 'Login Gagal');//->withInput($request->except('pw'));

            // Bisa Seperti ini
            // return redirect('/belajar-laravel/response/form-data')->with('gagal', 'Login Gagal')->withInput($request->except('pw'));
        }
        $data = [
            'title' => 'Form Result',
            'nama' => $request->input('name'),
            'email' => $request->input('email'),
        ];

        return response()->view('belajar.response.form_display', $data);
    }

    public function json_response_controller() {
        /*
            The json method will automatically set the Content-Type header to application/json, as well as convert the given array to
            JSON using the json_encode PHP function
        */
        return response()->json([
            'hobi' => 'Belajar',
            'makanan' => 'Nasi Goreng'
        ]);
    }

    public function jsop_response_controller(Request $request) {
        if($request->filled('callback')) {
            $data = ['Nasi' => 'Goreng', 'Tahu' => 'bulat'];
            /*
                If you would like to create a JSONP response, you may use the json method in combination with
                the withCallback method
                // return response()->json($data)->withCallback($request->input('callback'));
            */

            // Bisa Ditulis Juga Seperti Ini
            return response()->jsonp($request->input('callback'), $data);
        }

        $data = [
            'title' => 'JSONP Response'
        ];

        return response()->view('belajar.response.jsonp', $data);
    }

    public function download_file_controller() {
        /*
            The download method may be used to generate a response that forces the user's browser to download
            the file at the given path. The download method accepts a filename as the second argument to the
            method, which will determine the filename that is seen by the user downloading the file.
            Finally, you may pass an array of HTTP headers as the third argument to the method

            Symfony HttpFoundation, which manages file downloads, requires the file being downloaded to have
            an ASCII filename.
        */
        return response()->download(storage_path('app/public/image-1.jpg'), 'wallpaper.jpg');
    }

    public function file_response_controller() {
        /*
            The file method may be used to display a file, such as an image or PDF, directly in the user's
            browser instead of initiating a download. This method accepts the path to the file as its
            first argument and an array of headers as its second argument
        */
        return response()->file(storage_path('app/public/document.pdf'));
    }

    
}
