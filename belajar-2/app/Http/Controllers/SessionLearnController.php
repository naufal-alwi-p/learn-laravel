<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionLearnController extends Controller
{
    public function belajar_session_controller(Request $request) {
        $data = [
            'title' => 'Belajar Session',
            'hasSession' => $request->hasSession() ? "True" : "False"
        ];

        // There are two primary ways of working with session data in Laravel:
        // The global session helper
        $data['allDataSessionHelper'] = session()->all(); // If you would like to retrieve all the data in the session, you may use the all method
        // or via a Request instance
        $data['allDataSessionRequest'] = $request->session()->all();

        /*
            When you retrieve an item from the session, you may also pass a default value as the second argument to the get method.
            This default value will be returned if the specified key does not exist in the session. If you pass a closure as the
            default value to the get method and the requested key does not exist, the closure will be executed and its result returned
        */
        $data['getItem1'] = $request->session()->get('_token'); // Get an item from the session.
        $data['getItem2'] = $request->session()->get('nasi', 'Ga Ketemu'); // Return "Ga Ketemu" if the specified key does not exist in the session

        // You may also use the global session PHP function to retrieve and store data in the session
        // Retrieve a piece of data from the session...
        $data['getItem3'] = session('_previous')['url'];
        // Specifying a default value
        $data['getItem4'] = session('minum', 'Kosong');

        // To determine if an item is present in the session, you may use the has method. The has method returns true if the item is present and is not null
        if(!$request->session()->has('hobi')) {
            // Store a piece of data in the session
            session(['hobi' => 'Belajar Programming']);
        }
        // To determine if an item is present in the session, even if its value is null, you may use the exists method

        $data['getItem5'] = session('hobi', 'Ga Ada Hobi');

        // To determine if an item is not present in the session, you may use the missing method. The missing method returns true if the item is not present
        if($request->session()->missing('prodi')) {
            // To store data in the session, you will typically use the request instance's put method or the global session helper
            $request->session()->put('prodi', 'Ilmu Komputer'); // bisa juga dengan session(['prodi' => 'Ilmu Komputer']);
        }

        $data['getItem6'] = session('prodi');

        if($request->session()->missing('user')) {
            $request->session()->put('user', []);
        } else if(count(session('user')) < 5) {
            // The push method may be used to push a new value onto a session value that is an array.
            $request->session()->push('user', fake()->name());
        } else {
            // The pull method will retrieve and delete an item from the session in a single statement
            session()->pull('user');
        }

        $data['arraySession1'] = session('user', 'Kosong');

        // If your session data contains an integer you wish to increment or decrement, you may use the increment and decrement methods
        if($request->session()->missing('counter')) {
            session(['counter' => 0]);
        } else if(session('counter') < 10) {
            $request->session()->increment('counter');
        } else {
            // The forget method will remove a piece of data from the session.
            // Forget a single key
            $request->session()->forget('counter');
        }

        $data['counterSession'] = session('counter', 'No Value');

        if($request->session()->missing('countInfo')) {
            session(['countInfo' => 1]);

            /*
                Sometimes you may wish to store items in the session for the next request. You may do so using the flash method.
                Data stored in the session using this method will be available immediately and during the subsequent HTTP request.
                After the subsequent HTTP request, the flashed data will be deleted. Flash data is primarily useful for short-lived
                status messages

                To persist your flash data only for the current request, you may use the now method
            */
            // $request->session()->flash('info', fake()->numerify("###-#####-###"));
            $request->session()->now('info', fake()->numerify("###-#####-###"));

            /*
                If you need to persist your flash data for several requests, you may use the reflash method, which will keep all of the
                flash data for an additional request. If you only need to keep specific flash data, you may use the keep method
            */
        } else if(session('countInfo') === 3) {
            session()->pull('countInfo');
        } else {
            session()->increment('countInfo');
        }

        $data['countInfo'] = session('countInfo', 'null');

        // If you would like to remove all data from the session, you may use the flush method
        // session()->flush();

        /*
            Regenerating the session ID is often done in order to prevent malicious users from exploiting a session fixation attack on your
            application.

            If you need to manually regenerate the session ID, you may use the regenerate method
        */
        // Selain me-regenerate session ID, juga me-regenerate token CSRF
        // $request->session()->regenerate();

        /*
            If you need to regenerate the session ID and remove all data from the session in a single statement, you may use the
            invalidate method
        */
        // $request->session()->invalidate();

        // Regenerate the CSRF token value.
        // $request->session()->regenerateToken();

        // There are two primary ways of working with session data in Laravel:
        // The global session helper
        $data['allDataSessionHelper'] = session()->all(); // If you would like to retrieve all the data in the session, you may use the all method
        // or via a Request instance
        $data['allDataSessionRequest'] = $request->session()->all();

        return view('belajar.session', $data);
    }
}
