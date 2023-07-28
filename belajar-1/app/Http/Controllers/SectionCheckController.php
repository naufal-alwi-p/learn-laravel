<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/*
    If a controller action is particularly complex, you might find it convenient to dedicate an entire controller class to
    that single action. To accomplish this, you may define a single __invoke method within the controller

    When registering routes for single action controllers, you do not need to specify a controller method. Instead, you may
    simply pass the name of the controller to the router

    You may generate an invokable controller by using the --invokable option of the make:controller Artisan command

    -> php artisan make:controller ProvisionServer --invokable

    Controller stubs may be customized using stub publishing.
*/

class SectionCheckController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        //

        return View::make('sectionCheck.cekSection');
    }
}
