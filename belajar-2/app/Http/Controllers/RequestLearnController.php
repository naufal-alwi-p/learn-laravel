<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RequestLearnController extends Controller
{
    public function request_index_controller() {
        $listLink = collect(Route::getRoutes()->getRoutesByMethod()["GET"]);

        $data = [
            'title' => 'Daftar Isi Belajar Request Laravel',
            'links' => $listLink->filter(fn($route) => ($route->getPrefix() === 'belajar-laravel/request'))->values()
        ];

        return view('belajar.index_2', $data);
    }

    /*
        Laravel's Illuminate\Http\Request class provides an object-oriented way to interact with the current HTTP request being
        handled by your application as well as retrieve the input, cookies, and files that were submitted with the request.

        Accessing The Request
        To obtain an instance of the current HTTP request via dependency injection, you should type-hint the Illuminate\Http\Request
        class on your route closure or controller method. The incoming request instance will automatically be injected by the
        Laravel service container

        If your controller method is also expecting input from a route parameter you should list your route parameters after your
        other dependencies
    */

    public function accessing_request_controller(Request $request) {
        $data = [
            'title' => 'Accessing Request HTTP'
        ];

        /*
            The Illuminate\Http\Request instance provides a variety of methods for examining the incoming HTTP request and extends
            the Symfony\Component\HttpFoundation\Request class. We will discuss a few of the most important methods below.
        */

        // The path method returns the request's path information. So, if the incoming request is targeted at http://example.com/foo/bar, the
        // path method will return foo/bar
        $data['request_path'] = $request->path();

        // The is method allows you to verify that the incoming request path matches a given pattern. You may use the * character as a wildcard
        // when utilizing this method
        $data['is'] = $request->is('*request/accessing-request-http') ? "true" : "false";

        // Using the routeIs method, you may determine if the incoming request has matched a named route
        $data['routeIs'] = $request->routeIs('request.*') ? "true" : "false";

        // To retrieve the full URL for the incoming request you may use the url or fullUrl methods. The url method will return the URL
        // without the query string, while the fullUrl method includes the query string
        $data['url'] = $request->url();
        $data['fullUrl'] = $request->fullUrl();

        // If you would like to append query string data to the current URL, you may call the fullUrlWithQuery method. This method merges the
        // given array of query string variables with the current query string
        $data['fullUrlWithQuery'] = $request->fullUrlWithQuery(['nama' => 'Naruto Uzumaki', 'cita-cita' => 'Hokage']);

        //If you would like to get the current URL without a given query string parameter, you may utilize the fullUrlWithoutQuery method
        $data['fullUrlWithoutQuery'] = $request->fullUrlWithoutQuery('nama');

        // You may retrieve the "host" of the incoming request via the host, httpHost, and schemeAndHttpHost methods
        $data['host'] = $request->host();
        $data['httpHost'] = $request->httpHost();
        $data['schemeAndHttpHost'] = $request->schemeAndHttpHost();
        $data['scheme'] = $request->getScheme();

        // The method method will return the HTTP verb for the request. You may use the isMethod method to verify that the HTTP verb matches
        // a given string
        $data['method'] = $request->method();
        $data['isMethod'] = $request->isMethod('get') ? "true" : "false";

        // You may retrieve a request header from the Illuminate\Http\Request instance using the header method. If the header is not present
        // on the request, null will be returned. However, the header method accepts an optional second argument that will be returned if
        // the header is not present on the request
        $data['headerAccept'] = $request->header('Accept', 'null');
        // The hasHeader method may be used to determine if the request contains a given header
        $data['hasHeaderAcceptLanguage'] = $request->hasHeader('Accept-Language') ? "true" : "false";

        // The ip method may be used to retrieve the IP address of the client that made the request to your application
        $data['ipAddress'] = $request->ip();

        // Laravel provides several methods for inspecting the incoming request's requested content types via the Accept header.
        // First, the getAcceptableContentTypes method will return an array containing all of the content types accepted by the request
        $data['AcceptableContentType'] = $request->getAcceptableContentTypes();

        // The accepts method accepts an array of content types and returns true if any of the content types are accepted by the request.
        // Otherwise, false will be returned
        $data['isAccepted'] = $request->accepts(['application/json']) ? "true" : "false";

        // You may use the prefers method to determine which content type out of a given array of content types is most preferred by the
        // request. If none of the provided content types are accepted by the request, null will be returned
        $contentType = collect($data['AcceptableContentType']);
        $data['preferredContent'] = [];

        while($contentType->count() !== 0) {
            /* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
            $hasil = $request->prefers($contentType->values()->all());
            /* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */

            array_push($data['preferredContent'], $hasil);

            $index = $contentType->search($hasil);

            $contentType->forget($index);
            
            // Bisa ditulis seperti ini:
            // $data['preferredContent'][] = $contentType->pull($contentType->search($request->prefers($contentType->values()->all())));
        }

        // Since many applications only serve HTML or JSON, you may use the expectsJson method to quickly determine if the incoming
        // request expects a JSON response
        $data['expectJson'] = $request->expectsJson() ? "true" : "false";

        $data['isJson'] = $request->isJson() ? 'true' : 'false'; // Determine if the request is sending JSON.
        $data['wantsJson'] = $request->wantsJson() ? 'true' : 'false'; // Determine if the current request is asking for JSON.
        $data['acceptsJson'] = $request->acceptsJson() ? 'true' : 'false'; // Determines whether a request accepts JSON.
        $data['acceptsHtml'] = $request->acceptsHtml() ? 'true' : 'false'; // Determines whether a request accepts HTML.
        $data['format'] = $request->format(); // Get the data format expected in the response.
        $data['server'] = $request->server(); // Retrieve a server variable from the request.
        $data['root'] = $request->root(); // Get the root URL for the application.
        $data['decodedPath'] = $request->decodedPath(); // Get the current decoded path info for the request.
        $data['segments'] = $request->segments(); // Get all of the segments for the request path.
        $data['userAgent'] = $request->userAgent(); // Get the client user agent.
        $data['secure'] = $request->secure() ? 'true' : 'false'; // Determine if the request is over HTTPS.
        $data['ajax'] = $request->ajax() ? 'true' : 'false'; // Determine if the request is the result of an AJAX call.
        $data['pjax'] = $request->pjax() ? 'true' : 'false'; // Determine if the request is the result of a PJAX call.
        $data['prefetch'] = $request->prefetch() ? 'true' : 'false'; // Determine if the request is the result of a prefetch call.

        return view('belajar.request.access', $data);
    }

    public function form_input_request_controller(Request $request) {
        $data = [
            'title' => 'Form Input Data',
            'action_url' => $request->fullUrlWithQuery(['Universitas' => 'Harvard', 'Jenjang' => 'S1', 'Tua' => 21, 'Nickname' => 'Rizki Fathur', 'tes' => ['tahu', 12, 43.5]])
        ];

        // Retrieving Old Input
        /*
            To retrieve flashed input from the previous request, invoke the old method on an instance of Illuminate\Http\Request. The old
            method will pull the previously flashed input data from the session

            Laravel also provides a global old helper. If you are displaying old input within a Blade template, it is more convenient
            to use the old helper to repopulate the form. If no old input exists for the given field, null will be returned
        */

        $data['username'] = $request->old('username');
        $data['email'] = $request->old('email');
        $data['waktu'] = $request->old('waktu');

        if($request->old('game_console')) {
            foreach($request->old('game_console') as $nilai) {
                if(str_contains($nilai, " ")) {
                    $nilai = str_replace(" ", "_", $nilai);
                }
                $data[$nilai] = $nilai;
            }
        }

        $data['kelas'] = $request->old('kelas');

        if($request->old('olahraga')) {
            foreach($request->old('olahraga') as $nilai) {
                if(str_contains($nilai, " ")) {
                    $nilai = str_replace(" ", "_", $nilai);
                }
                $data[$nilai] = $nilai;
            }
        }

        $data['notification'] = $request->old('notification');

        $data['allSessionData'] = $request->session()->all();

        return view('belajar.request.form', $data);
    }

    public function form_input_result_controller(Request $request) {
        $data = [
            'title' => 'Hasil Input Data Form'
        ];

        // You may retrieve all of the incoming request's input data as an array using the all method. This method may be used
        // regardless of whether the incoming request is from an HTML form or is an XHR request
        $data['allInputArray'] = $request->all();
        
        // Using the collect method, you may retrieve all of the incoming request's input data as a collection
        $data['allInputCollect'] = $request->collect();

        // Using a few simple methods, you may access all of the user input from your Illuminate\Http\Request instance without
        // worrying about which HTTP verb was used for the request. Regardless of the HTTP verb, the input method may be used
        // to retrieve user input
        $data['pw1'] = $request->input('password');

        // You may pass a default value as the second argument to the input method. This value will be returned if the requested
        // input value is not present on the request (Kalo ga ada, tapi kalo isinya string kosong "" dianggap ada)
        $data['email1'] = $request->input('email', 'Kosong');
        $data['universitas'] = $request->input('Universitas', 'Kosong');

        // When working with forms that contain array inputs, use "dot" notation to access the arrays
        $data['arrOlahraga'] = $request->input('olahraga.1');

        // You may call the input method without any arguments in order to retrieve all of the input values as an associative array
        // $data['allInputArray'] = $request->input(); // Sama dengan $request->all();

        // While the input method retrieves values from the entire request payload (including the query string), the query method
        // will only retrieve values from the query string
        $data['universitas2'] = $request->query('Universitas');
        $data['jenjang'] = $request->query('Jenjang');
        $data['umur'] = $request->query('Tua');
        // If the requested query string value data is not present, the second argument to this method will be returned
        $data['nama1'] = $request->query('Nickname', 'kosong');
        $data['tes'] = implode(', ', $request->query('tes'));
        // You may call the query method without any arguments in order to retrieve all of the query string values as an associative array
        // $request->query()

        // Instead of retrieving the request's input data as a primitive string, you may use the string method to retrieve the request data
        // as an instance of Illuminate\Support\Stringable
        $data['username1'] = $request->string('username')->start('Hello, ')->value();

        // When dealing with HTML elements like checkboxes, your application may receive "truthy" values that are actually strings.
        // For example, "true" or "on". For convenience, you may use the boolean method to retrieve these values as booleans.
        // The boolean method returns true for 1, "1", true, "true", "on", and "yes". All other values will return false
        $data['notification1'] = $request->boolean('notification') ? 'true' : 'false';

        // For convenience, input values containing dates / times may be retrieved as Carbon instances using the date method. If the request
        // does not contain an input value with the given name, null will be returned
        // The second and third arguments accepted by the date method may be used to specify the date's format and timezone, respectively
        // If the input value is present but has an invalid format, an InvalidArgumentException will be thrown; therefore, it is recommended
        // that you validate the input before invoking the date method.
        $data['schedule'] = $request->date('waktu')->format('j F Y h:i:s:v:u A');

        // You may also access user input using dynamic properties on the Illuminate\Http\Request instance. For example, if one of your
        // application's forms contains a username field, you may access the value of the field like so
        $data['username2'] = $request->username;
        $data['nama2'] = $request->Nickname;
        $data['universitas3'] = $request->Universitas;
        // When using dynamic properties, Laravel will first look for the parameter's value in the request payload. If it is not
        // present, Laravel will search for the field in the matched route's parameters.

        // If you need to retrieve a subset of the input data, you may use the only and except methods. Both of these methods accept
        // a single array or a dynamic list of arguments
        $data['subsetData1'] = $request->only(['username', 'email', 'password', 'waktu', 'kelas', 'Universitas', 'Jenjang']);
        // The only method returns all of the key / value pairs that you request; however, it will not return key / value pairs that
        // are not present on the request.
        $data['subsetData2'] = $request->except(['game_console', 'olahraga']);

        // You may use the has method to determine if a value is present on the request. The has method returns true if the value
        // is present on the request
        $data['hasEmail'] = $request->has('email') ? 'true' : 'false'; // Walaupun isinya string kosong "" tetap dianggap ada
        $data['hasAddress'] = $request->has('address') ? 'true' : 'false';
        // When given an array, the has method will determine if all of the specified values are present
        $data['hasAllOfThisInput'] = $request->has(['username', 'Nickname']) ? 'true' : 'false'; // Semua harus ada walaupun cuma string kosong "" baru dianggap true
        // The hasAny method returns true if any of the specified values are present
        $data['hasOneOfThisInput'] = $request->hasAny(['password', 'olahraga']) ? 'true' : 'false'; // Cukup salah satu ada walaupun cuma string kosong "" baru dianggap true
        // The whenHas method will execute the given closure if a value is present on the request
        // $request->whenHas('key', function() { ... });
        // A second closure may be passed to the whenHas method that will be executed if the specified value is not present on the request
        // $request->whenHas('key', function() { ... }, function() { ... });

        // If you would like to determine if a value is present on the request and is not an empty string, you may use the filled method
        $data['filledEmail'] = $request->filled('email') ? 'true' : 'false'; // Harus ada dan isinya bukan string kosong "" baru hasilnya true
        $data['filledAllOfThisInput'] = $request->filled(['username', 'olahraga']) ? 'true' : 'false';
        // The anyFilled method returns true if any of the specified values is not an empty string
        $data['filledOneOfThisInput'] = $request->anyFilled(['password', 'kelas']) ? 'true' : 'false';
        // The whenFilled method will execute the given closure if a value is present on the request and is not an empty string
        // $request->whenFilled('key', function() { ... });
        // A second closure may be passed to the whenFilled method that will be executed if the specified value is not "filled"
        // $request->whenFilled('key', function() { ... }, function() { ... });

        // To determine if a given key is absent from the request, you may use the missing and whenMissing methods
        $data['missingEmail'] = $request->missing('email') ? 'true' : 'false';
        $data['missingAddress'] = $request->missing('address') ? 'true' : 'false';
        $data['missingAllOfThisInput'] = $request->missing(['password', 'username', 'tahu']) ? 'true' : 'false'; // Semua harus ada walaupun isinya string kosong "" baru dianggap true
        // $request->whenMissing('key', function() { when missing... }, function() { when not missing... });

        // Sometimes you may need to manually merge additional input into the request's existing input data. To accomplish this, you may
        // use the merge method. If a given input key already exists on the request, it will be overwritten by the data provided to the
        // merge method
        $request->merge(['makanan' => 'Mie Ramen', 'Nickname' => 'rebahan']);
        // The mergeIfMissing method may be used to merge input into the request if the corresponding keys do not already exist within
        // the request's input data
        $request->mergeIfMissing(['username' => 'Naruto', 'address' => 'Mountain View, California, Amerika']);
        $data['withAdditionalInput'] = $request->all();

        // Old Input
        /*
            Laravel allows you to keep input from one request during the next request. This feature is particularly useful for re-populating
            forms after detecting validation errors. However, if you are using Laravel's included validation features, it is possible that
            you will not need to manually use these session input flashing methods directly, as some of Laravel's built-in validation
            facilities will call them automatically.

            Flashing Input To The Session

            The flash method on the Illuminate\Http\Request class will flash the current input to the session so that it is available during
            the user's next request to the application
        */
        // $request->flash()
        /*
            You may also use the flashOnly and flashExcept methods to flash a subset of the request data to the session. These methods are
            useful for keeping sensitive information such as passwords out of the session
        */
        // $request->flashOnly();
        // $request->flashExcept();

        /*
            Flashing Input Then Redirecting

            Since you often will want to flash input to the session and then redirect to the previous page, you may easily chain input
            flashing onto a redirect using the withInput method
        */
        if($request->input('password') !== 'nasi') {
            $request->flashOnly(['username', 'email', 'waktu', 'game_console', 'kelas', 'olahraga', 'notification']);
            return back();

            // Bisa juga ditulis
            // return back()->withInput($request->only(['username', 'email', 'waktu', 'game_console', 'kelas', 'olahraga', 'notification']));
            // return redirect('/belajar-laravel/request/form-input-request-http')->withInput($request->only(['username', 'email', 'waktu', 'game_console', 'kelas', 'olahraga', 'notification']));
        }

        /*
            All cookies created by the Laravel framework are encrypted and signed with an authentication code, meaning they will be
            considered invalid if they have been changed by the client. To retrieve a cookie value from the request, use the
            cookie method on an Illuminate\Http\Request instance
        */
        $data['haslaravel_sessionCookie'] = $request->hasCookie('laravel_session') ? 'true' : 'false';
        $data['XSRFTokenCookie'] = $request->cookie('XSRF-TOKEN');
        $data['allCookies'] = $request->cookie();

        $data['allDataSession'] = $request->session()->all();

        return view('belajar.request.form_result', $data);
    }
}
