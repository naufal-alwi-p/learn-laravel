<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidationLearnRequest;
use App\Rules\CustomRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Fluent;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class ValidationLearnController extends Controller
{
    /*
        Introduction

        Laravel provides several different approaches to validate your application's incoming data. It is most common to use the validate
        method available on all incoming HTTP requests. However, we will discuss other approaches to validation as well.

        Laravel includes a wide variety of convenient validation rules that you may apply to data, even providing the ability to validate
        if values are unique in a given database table. We'll cover each of these validation rules in detail so that you are familiar
        with all of Laravel's validation features.

        Validation Quickstart

        To learn about Laravel's powerful validation features, let's look at a complete example of validating a form and displaying the
        error messages back to the user. By reading this high-level overview, you'll be able to gain a good general understanding of
        how to validate incoming request data using Laravel
    */

    public function validation_index_controller() {
        $listLink = collect(Route::getRoutes()->getRoutesByMethod()["GET"]);

        $data = [
            'title' => 'Validation',
            'links' => $listLink->filter(fn($route) => ($route->getPrefix() === 'belajar-laravel/validation'))->values()
        ];

        return view('belajar.index_2', $data);
    }

    public function validation_form1_controller() {
        $data = [
            'title' => 'Form 1',
            'actionUrl' => route('valdiation.rule-1')
        ];

        if (old('hobi')) {
            foreach (old('hobi') as $value) {
                $data[str_replace(' ', '_', $value)] = true;
            }
        }

        return view('belajar.validation.form1', $data);
    }

    public function validator1_controller(Request $request) {
        /*
            Writing The Validation Logic

            Now we are ready to fill in our controller method with the logic to validate the incoming input data. To do this, we will
            use the validate method provided by the Illuminate\Http\Request object. If the validation rules pass, your code will keep
            executing normally; however, if validation fails, an Illuminate\Validation\ValidationException exception will be thrown
            and the proper error response will automatically be sent back to the user.

            If validation fails during a traditional HTTP request, a redirect response to the previous URL will be generated. If the
            incoming request is an XHR request, a JSON response containing the validation error messages will be returned.
        */

        // $validated = $request->validate([
        //     'nama' => 'required',
        //     'email' => 'email',
        //     'umur' => 'integer|numeric',
        //     'lahir' => 'date',
        //     'telepon' =>'regex:/[0-9]{4}-[0-9]{4}-[0-9]{4}/|',
        //     'link' => 'url:http,https|active_url',
        //     'file' => 'file',
        //     // Alternatively, validation rules may be specified as arrays of rules instead of a single | delimited string
        //     'hobi' => ['nullable', 'array'],
        //     'setuju' => 'accepted'
        // ]);

        /*
            As you can see, the validation rules are passed into the validate method. Don't worry - all available validation rules are
            documented. Again, if the validation fails, the proper response will automatically be generated. If the validation
            passes, our controller will continue executing normally.
        */

        // In addition, you may use the validateWithBag method to validate a request and store any error messages within a named error bag
        $validated = $request->validateWithBag('nama_bebas', [
            'nama' => 'required',
            'email' => 'email',
            // Stopping On First Validation Failure: Sometimes you may wish to stop running validation rules on an attribute after the first validation failure. To do so, assign
            // the bail rule to the attribute
            'umur' => 'bail|integer|numeric', // In this example, if the interger rule on the umur attribute fails, the numeric rule will not be checked. Rules will be validated in the order they are assigned.
            'lahir' => 'date',
            'telepon' =>'regex:/[0-9]{4}-[0-9]{4}-[0-9]{4}/|',
            'link' => 'url:http,https|active_url',
            'file' => 'file|mimetypes:image/*',
            /*
                A Note On Optional Fields

                By default, Laravel includes the TrimStrings and ConvertEmptyStringsToNull middleware in your application's global middleware
                stack. These middleware are listed in the stack by the App\Http\Kernel class. Because of this, you will often need to mark
                your "optional" request fields as nullable if you do not want the validator to consider null values as invalid.
            */
            // Alternatively, validation rules may be specified as arrays of rules instead of a single | delimited string
            'hobi' => ['nullable', 'array'],
            // If the incoming HTTP request contains "nested" field data, you may specify these fields in your validation rules using "dot" syntax
            'hobi.2' => 'required',
            // On the other hand, if your field name contains a literal period, you can explicitly prevent this from being interpreted as "dot"
            // syntax by escaping the period with a backslash
            // 'nama\.field\.dengan\.titik' => 'required', (Ini Sekedar Contoh)
            'setuju' => 'accepted'
        ]);

        /*
            Customizing The Error Messages

            Laravel's built-in validation rules each have an error message that is located in your application's lang/en/validation.php file.
            If your application does not have a lang directory, you may instruct Laravel to create it using the lang:publish Artisan command.
            -> php artisan lang:publish

            Within the lang/en/validation.php file, you will find a translation entry for each validation rule. You are free to change or
            modify these messages based on the needs of your application.

            In addition, you may copy this file to another language directory to translate the messages for your application's language.
            To learn more about Laravel localization, check out the complete localization documentation.

            By default, the Laravel application skeleton does not include the lang directory. If you would like to customize Laravel's
            language files, you may publish them via the lang:publish Artisan command.
        */

        $validated['file'] = $validated['file']->getClientOriginalName();

        return back()->with(['success' => 'Data Anda Lolos Validasi', 'data' => $validated]);
    }

    public function xhr_form_controller() {
        $data = [
            'title' => 'XHR Form'
        ];

        return view('belajar.validation.xhr_form', $data);
    }

    public function xhr_validation_controller(Request $request) {
        /*
            XHR Requests & Validation

            In this example, we used a traditional form to send data to the application. However, many applications receive XHR requests
            from a JavaScript powered frontend. When using the validate method during an XHR request, Laravel will not generate
            a redirect response. Instead, Laravel generates a JSON response containing all of the validation errors. This JSON
            response will be sent with a 422 HTTP status code.
        */

        /*
            Validation Error Response Format

            When your application throws a Illuminate\Validation\ValidationException exception and the incoming HTTP request is
            expecting a JSON response, Laravel will automatically format the error messages for you and return a 422 Unprocessable
            Entity HTTP response.

            You can review an example of the JSON response format for validation errors. Note that nested error keys are
            flattened into "dot" notation format
        */
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        return response()->json([
            'isJson' => $request->isJson(),
            'expectJson' => $request->expectsJson(),
            'isXmlHttpRequest' => $request->isXmlHttpRequest(),
            'validated' => $validated
        ]);
    }

    public function validation_form2_controller() {
        $data = [
            'title' => 'Form 2',
            'actionUrl' => route('validation.rule-2')
        ];

        return view('belajar.validation.form2', $data);
    }

    /*
        So, how are the validation rules evaluated? All you need to do is type-hint the request on your controller method. The incoming
        form request is validated before the controller method is called, meaning you do not need to clutter your controller with any
        validation logic

        If validation fails, a redirect response will be generated to send the user back to their previous location. The errors will also
        be flashed to the session so they are available for display. If the request was an XHR request, an HTTP response with a 422
        status code will be returned to the user including a JSON representation of the validation errors.
    */
    public function validator2_controller(ValidationLearnRequest $request) {
        /*
            Working With Validated Input

            After validating incoming request data using a form request or a manually created validator instance, you may wish to retrieve
            the incoming request data that actually underwent validation. This can be accomplished in several ways. First, you may call
            the validated method on a form request or validator instance. This method returns an array of the data that was validated
        */
        dump($request->validated());

        /*
            Alternatively, you may call the safe method on a form request or validator instance. This method returns an instance of
            Illuminate\Support\ValidatedInput.
            In addition, the Illuminate\Support\ValidatedInput instance may be iterated over and accessed like an array
        */
        dump($request->safe());

        /*
            This object (Illuminate\Support\ValidatedInput) exposes only, except, and all methods to retrieve a subset of the
            validated data or the entire array of validated data
        */
        dump($request->safe()->all());

        /*
            If you would like to add additional fields to the validated data, you may call the merge method
        */
        dump($request->safe()->merge(['tes' => 'Data tambahan']));

        /*
            If you would like to retrieve the validated data as a collection instance, you may call the collect method
        */
        dd($request->safe()->collect());
    }

    public function validation_form3_controller() {
        $data = [
            'title' => 'Form 3',
            'actionUrl' => route('validation.rule-3')
        ];

        return view('belajar.validation.form3', $data);
    }

    /*
        Manually Creating Validators

        If you do not want to use the validate method on the request, you may create a validator instance manually using the
        Validator facade. The make method on the facade generates a new validator instance
    */

    public function validator3_controller(Request $request) {
        /*
            The first argument passed to the make method is the data under validation. The second argument is an array of the
            validation rules that should be applied to the data.

            Customizing The Error Messages
            If needed, you may provide custom error messages that a validator instance should use instead of the default error
            messages provided by Laravel. There are several ways to specify custom messages. First, you may pass the custom
            messages as the third argument to the Validator::make method

            Specifying Custom Attribute Values
            Many of Laravel's built-in error messages include an :attribute placeholder that is replaced with the name of the
            field or attribute under validation. To customize the values used to replace these placeholders for specific
            fields, you may pass an array of custom attributes as the fourth argument to the Validator::make method
        */
        $validate = Validator::make($request->all(), [
            'nama' => 'required|ascii|max:30',
            'email' => 'required|email:rfc,dns,spoof',
            'daftar' => 'required|after:2020-05-12|before:today'
        ], [
            /*
                In this example, the :attribute placeholder will be replaced by the actual name of the field under validation.
                You may also utilize other placeholders in validation messages.
            */
            'nama' => 'Isi :attribute yang bener woy, :max, :input',
            /*
                Specifying A Custom Message For A Given Attribute

                Sometimes you may wish to specify a custom error message only for a specific attribute. You may do so using "dot"
                notation. Specify the attribute's name first, followed by the rule
            */
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Isi email yang bener sesuai',
            'daftar' => 'Isi tanggal :attribute dengan benar'
        ], [
            'name' => 'Input Nama',
            'daftar' => 'pendaftaran'
        ]);

        /*
            The stopOnFirstFailure method will inform the validator that it should stop validating all attributes once a single
            validation failure has occurred
        */
        // $validate->stopOnFirstFailure();

        /*
            Automatic Redirection

            If you would like to create a validator instance manually but still take advantage of the automatic redirection offered
            by the HTTP request's validate method, you may call the validate method on an existing validator instance. If validation
            fails, the user will automatically be redirected or, in the case of an XHR request, a JSON response will be returned
        */
        // $result = $validate->validate();
        // You may use the validateWithBag method to store the error messages in a named error bag if validation fails
        // $result = $validate->validateWithBag('tes_coba');
        // dump($result);

        /*
            Performing Additional Validation

            Sometimes you need to perform additional validation after your initial validation is complete. You can accomplish
            this using the validator's after method. The after method accepts a closure or an array of callables which will
            be invoked after validation is complete. The given callables will receive an Illuminate\Validation\Validator
            instance, allowing you to raise additional error messages if necessary

            As noted, the after method also accepts an array of callables, which is particularly convenient if your
            "after validation" logic is encapsulated in invokable classes, which will receive an Illuminate\Validation\Validator
            instance via their __invoke method
        */

        $validate->after(function($validator) use ($validate) {
            $nama = explode(' ', $validate->validated()['nama']);
            
            foreach ($nama as $word) {
                if (ctype_lower($word[0])) {
                    $validator->errors()->add(
                        'nama',
                        'Nama harus diawali huruf kapital per kata'
                    );
                    break;
                }
            }
        });

        /*
            After determining whether the request validation failed, you may use the withErrors method to flash the error messages
            to the session. When using this method, the $errors variable will automatically be shared with your views after
            redirection, allowing you to easily display them back to the user. The withErrors method accepts
            a validator, a MessageBag, or a PHP array
        */

        if ($validate->fails()) {
            /*
                Working With Error Messages

                After calling the errors method on a Validator instance, you will receive an Illuminate\Support\MessageBag instance, which
                has a variety of convenient methods for working with error messages. The $errors variable that is automatically made
                available to all views is also an instance of the MessageBag class

                Retrieving The First Error Message For A Field

                To retrieve the first error message for a given field, use the first method
            */
            dump($validate->errors()->first('email'));
            dump($validate->errors()->first());

            // Retrieving All Error Messages For A Field
            // If you need to retrieve an array of all the messages for a given field, use the get method
            dump($validate->errors()->get('nama'));

            // If you are validating an array form field, you may retrieve all of the messages for each of the array elements using
            // the * character
            dump($validate->errors()->get('nama.*'));

            // Retrieving All Error Messages For All Fields
            // To retrieve an array of all messages for all fields, use the all method
            dump($validate->errors()->all());

            // Determining If Messages Exist For A Field
            // The has method may be used to determine if any error messages exist for a given field
            dd($validate->errors()->has('daftar'));


            /*
                Named Error Bags

                If you have multiple forms on a single page, you may wish to name the MessageBag containing the validation
                errors, allowing you to retrieve the error messages for a specific form. To achieve this, pass a name as
                the second argument to withErrors
            */
            return back()->withInput()->withErrors($validate/*, 'tes_coba'*/);

            /*
                You may then access the named MessageBag instance from the $errors variable

                {{ $errors->tes_coba->first('email') }} (Retrieving MessageBag Via Dynamic Properties)
            */
        }

        // dump($validate->validated());

        // dump(($validate->passes()));
        // dump($validate->fails());
        // dd($validate->failed());
    }

    public function validation_form4_controller() {
        $data = [
            'title' => 'Form 4',
            'actionUrl' => route('validation.rule-4')
        ];

        return view('belajar.validation.form4', $data);
    }

    public function validator4_controller(Request $request) {
        switch ($request->input('opsi')) {
            case 'accepted':
                // The field under validation must be "yes", "on", 1, or true. This is useful for validating
                // "Terms of Service" acceptance or similar fields.
                $validate = Validator::make($request->all(), [
                    'cek' => 'accepted'
                ]);

                if ($validate->fails()) {
                    return back()->withErrors($validate)->withInput();
                }

                $result = $validate->validated();

                return back()->with('pass', ['Data Passes Validation', $result]);
            case 'accepted_if':
                // accepted_if:anotherfield,value,...
                // The field under validation must be "yes", "on", 1, or true if another field under validation is equal to
                // a specified value. This is useful for validating "Terms of Service" acceptance or similar fields.
                $validate = Validator::make($request->all(), [
                    'cek' => 'accepted_if:data,nasi'
                ])->validate();

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'active_url':
                // The field under validation must have a valid A or AAAA record according to the dns_get_record PHP function.
                // The hostname of the provided URL is extracted using the parse_url PHP function before being passed to dns_get_record.
                $validate = Validator::make($request->all(), [
                    'data' => 'active_url'
                ])->validate();

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'after':
                /*
                    The field under validation must be a value after a given date. The dates will be passed into the strtotime PHP
                    function in order to be converted to a valid DateTime instance
                */
                $validate = Validator::make($request->all(), [
                    'data' => 'after:2022-05-01'
                ])->validate();

                // Instead of passing a date string to be evaluated by strtotime, you may specify another field to compare against the date

                return back()->with('pass', ['Data Passes Validation', $validate]);
                /*
                    after_or_equal:date

                    The field under validation must be a value after or equal to the given date. For more information, see the after rule.
                */
            case "alpha":
                /*
                    The field under validation must be entirely Unicode alphabetic characters contained in:
                    https://util.unicode.org/UnicodeJsps/list-unicodeset.jsp?a=%5B%3AL%3A%5D&g=&i=
                    https://util.unicode.org/UnicodeJsps/list-unicodeset.jsp?a=%5B%3AM%3A%5D&g=&i=

                    To restrict this validation rule to characters in the ASCII range (a-z and A-Z), you may provide the
                    ascii option to the validation rule
                */
                $validate = Validator::make($request->all(), [
                    'data' => 'alpha'
                ])->validate();

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'alpha_dash':
                /*
                    The field under validation must be entirely Unicode alpha-numeric characters contained in:
                    https://util.unicode.org/UnicodeJsps/list-unicodeset.jsp?a=%5B%3AL%3A%5D&g=&i=
                    https://util.unicode.org/UnicodeJsps/list-unicodeset.jsp?a=%5B%3AM%3A%5D&g=&i=
                    https://util.unicode.org/UnicodeJsps/list-unicodeset.jsp?a=%5B%3AN%3A%5D&g=&i=

                    as well as ASCII dashes (-) and ASCII underscores (_).

                    To restrict this validation rule to characters in the ASCII range (a-z and A-Z), you may provide the
                    ascii option to the validation rule
                */
                $validate = Validator::make($request->all(), [
                    'data' => 'alpha_dash'
                ])->validate();

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'alpha_num':
                /*
                    The field under validation must be entirely Unicode alpha-numeric characters contained in:
                    https://util.unicode.org/UnicodeJsps/list-unicodeset.jsp?a=%5B%3AL%3A%5D&g=&i=
                    https://util.unicode.org/UnicodeJsps/list-unicodeset.jsp?a=%5B%3AM%3A%5D&g=&i=
                    https://util.unicode.org/UnicodeJsps/list-unicodeset.jsp?a=%5B%3AN%3A%5D&g=&i=

                    To restrict this validation rule to characters in the ASCII range (a-z and A-Z), you may provide the
                    ascii option to the validation rule
                */
                $validate = $request->validate([
                    'data' => 'alpha_num'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'array':
                /*
                    The field under validation must be a PHP array.

                    When additional values are provided to the array rule, each key in the input array must be present within
                    the list of values provided to the rule. In the following example, the admin key in the input array is
                    invalid since it is not contained in the list of values provided to the array rule
                    In general, you should always specify the array keys that are allowed to be present within your array.
                */
                $request->merge([
                    'data' => json_decode($request->input('data'), true)
                ]);

                $validate = Validator::make($request->all(), [
                    'data' => 'array'
                ]);

                if ($validate->fails()) {
                    $request->merge([
                        'data' => collect($request->input('data'))
                    ]);

                    return back()->withErrors($validate)->withInput($request->all());
                }

                return back()->with('pass', ['Data Passes Validation', $validate->validated()]);
            case 'ascii':
                // The field under validation must be entirely 7-bit ASCII characters.
                $validate = $request->validate([
                    'data' => 'ascii'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'bail':
                /*
                    Stop running validation rules for the field after the first validation failure.

                    While the bail rule will only stop validating a specific field when it encounters a validation failure, the
                    stopOnFirstFailure method will inform the validator that it should stop validating all attributes once
                    a single validation failure has occurred
                */
                $validate = $request->validate([
                    'data' => 'bail|ascii|max:3'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            // case 'before':
            //     // The field under validation must be a value preceding the given date. The dates will be passed into the PHP
            //     // strtotime function in order to be converted into a valid DateTime instance. In addition, like the after
            //     // rule, the name of another field under validation may be supplied as the value of date.
            // case 'before_or_equal':
            //     // The field under validation must be a value preceding or equal to the given date. The dates will be passed
            //     // into the PHP strtotime function in order to be converted into a valid DateTime instance. In addition, like
            //     // the after rule, the name of another field under validation may be supplied as the value of date.
            case 'size(string)':
                // The field under validation must have a size matching the given value. For string data, value corresponds to
                // the number of characters.
                $validate = $request->validate([
                    'data' => 'size:3'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'size(numeric)':
                // The field under validation must have a size matching the given value. For numeric data, value corresponds to
                // a given integer value (the attribute must also have the numeric or integer rule).
                $validate = $request->validate([
                    'data' => 'numeric|size:5'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'size(array)':
                // The field under validation must have a size matching the given value. For an array, size corresponds to
                // the count of the array.
                $request->merge([
                    'data' => json_decode($request->input('data'), true)
                ]);

                $validate = Validator::make($request->all(), [
                    'data' => 'array|size:5'
                ]);

                if ($validate->fails()) {
                    $request->merge([
                        'data' => collect($request->input('data'))
                    ]);

                    return back()->withErrors($validate)->withInput($request->all());
                }

                return back()->with('pass', ['Data Passes Validation', $validate->validated()]);
                // For files, size corresponds to the file size in kilobytes.
            case 'between(file)':
                /*
                    The field under validation must have a size between the given min and max (inclusive).
                    Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
                */

                $validate = $request->validate([
                    'file_upload' => 'required|file|between:100,1000'
                ]);

                $validate['file_upload'] = $validate['file_upload']->getClientOriginalName();

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'confirmed':
                /*
                    The field under validation must have a matching field of {field}_confirmation. For example, if
                    the field under validation is password, a matching password_confirmation field must be
                    present in the input.
                */
                $validate = $request->validate([
                    'data' => 'confirmed'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case "decimal":
                /*
                    decimal:min,max
                    The field under validation must be numeric and must contain the specified number of decimal places
                */
                $validate = $request->validate([
                    'data' => 'decimal:5,7'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'digit':
                /*
                    The integer under validation must have an exact length of value.
                */
                $validate = $request->validate([
                    'data' => 'digits:5'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'dimensions':
                /*
                    The file under validation must be an image meeting the dimension constraints as specified by the rule's parameters

                    Available constraints are: min_width, max_width, min_height, max_height, width, height, ratio.
                    A ratio constraint should be represented as width divided by height. This can be specified either by a fraction
                    like 3/2 or a float like 1.5
                    Since this rule requires several arguments, you may use the Rule::dimensions method to fluently construct the rule
                */
                $validate = $request->validate([
                    'file_upload' => 'image|dimensions:min_width=1000,min_height=500'
                ]);

                $validate['file_upload'] = $validate['file_upload']->getClientOriginalName();

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'exists':
                /*
                    The field under validation must exist in a given database table.
                    If the column option is not specified, the field name will be used. So, in this case, the rule will validate that
                    the states database table contains a record with a state column value matching the request's state attribute value.

                    Specifying A Custom Column Name
                    You may explicitly specify the database column name that should be used by the validation rule by placing it after
                    the database table name
                    Occasionally, you may need to specify a specific database connection to be used for the exists query. You can
                    accomplish this by prepending the connection name to the table name

                    Instead of specifying the table name directly, you may specify the Eloquent model which should be used to determine
                    the table name

                    If you would like to customize the query executed by the validation rule, you may use the Rule class to fluently
                    define the rule. In this example, we'll also specify the validation rules as an array instead of using the | character
                    to delimit them

                    You may explicitly specify the database column name that should be used by the exists rule generated by the
                    Rule::exists method by providing the column name as the second argument to the exists method
                */
                $validate = $request->validate([
                    'data' => 'exists:App\Models\User,name'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'in':
                /*
                    The field under validation must be included in the given list of values. Since this rule often requires you to
                    implode an array, the Rule::in method may be used to fluently construct the rule

                    When the in rule is combined with the array rule, each value in the input array must be present within the
                    list of values provided to the in rule. In the following example, the LAS airport code in the input array
                    is invalid since it is not contained in the list of airports provided to the in rule
                */
                $validate = $request->validate([
                    'data' => 'in:tes,kopi'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'ipv6':
                // The field under validation must be an IPv6 address.
                $validate = $request->validate([
                    'data' => 'ipv6'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'mimetypes':
                /*
                    The file under validation must match one of the given MIME types

                    To determine the MIME type of the uploaded file, the file's contents will be read and the framework will
                    attempt to guess the MIME type, which may be different from the client's provided MIME type.
                */
                $validate = $request->validate([
                    'file_upload' => 'mimetypes:image/*'
                ]);

                $validate['file_upload'] = $validate['file_upload']->getClientOriginalName();

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'multiple_of':
                // The field under validation must be a multiple of value.
                $validate = $request->validate([
                    'data' => 'multiple_of:3'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'same':
                // The given field must match the field under validation.
                $validate = $request->validate([
                    'data' => 'same:data_confirmation'
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'unique':
                /*
                    The field under validation must not exist within the given database table.

                    Instead of specifying the table name directly, you may specify the Eloquent model which should be used
                    to determine the table name

                    The column option may be used to specify the field's corresponding database column. If the column option
                    is not specified, the name of the field under validation will be used.

                    Occasionally, you may need to set a custom connection for database queries made by the Validator.
                    To accomplish this, you may prepend the connection name to the table name

                    Sometimes, you may wish to ignore a given ID during unique validation. For example, consider an "update profile"
                    screen that includes the user's name, email address, and location. You will probably want to verify that the
                    email address is unique. However, if the user only changes the name field and not the email field, you do
                    not want a validation error to be thrown because the user is already the owner of the email address in question.

                    To instruct the validator to ignore the user's ID, we'll use the Rule class to fluently define the rule. In this
                    example, we'll also specify the validation rules as an array instead of using the | character to delimit the rules

                    You should never pass any user controlled request input into the ignore method. Instead, you should only pass
                    a system generated unique ID such as an auto-incrementing ID or UUID from an Eloquent model instance.
                    Otherwise, your application will be vulnerable to an SQL injection attack.

                    Instead of passing the model key's value to the ignore method, you may also pass the entire model instance.
                    Laravel will automatically extract the key from the model

                    If your table uses a primary key column name other than id, you may specify the name of the column when calling
                    the ignore method

                    By default, the unique rule will check the uniqueness of the column matching the name of the attribute being
                    validated. However, you may pass a different column name as the second argument to the unique method

                    You may specify additional query conditions by customizing the query using the where method. For example, let's
                    add a query condition that scopes the query to only search records that have an account_id column value of 1
                */
                $validate = $request->validate([
                    'data' => [Rule::unique(\App\Models\User::class, 'username')->ignore(11)],
                    'data_confirmation' => [Rule::unique(\App\Models\User::class, 'email')->ignore(11)]
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'conditionally adding rules':
                /*
                    You may occasionally wish to not validate a given field if another field has a given value. You may accomplish this
                    using the exclude_if validation rule.

                    Alternatively, you may use the exclude_unless rule to not validate a given field unless another field has a given value

                    In some situations, you may wish to run validation checks against a field only if that field is present in the data
                    being validated. To quickly accomplish this, add the sometimes rule to your rule list
                */

                if ($request->filled('data')) {
                    $request->merge([
                        'data' => json_decode($request->input('data'), true)
                    ]);
                }

                // if ($request->missing('file_upload')) {
                //     $request->merge(['file_upload' => null]);
                // }

                $validate = Validator::make($request->all(), [
                    'data' => 'required',
                    'file_upload' => 'sometimes|required|file', // The file_upload field will only be validated if it is present in the $request->all() array
                    'cek' => 'sometimes|required|accepted'
                ]);

                /*
                    Sometimes you may wish to add validation rules based on more complex conditional logic. For example, you may wish
                    to require a given field only if another field has certain value. Or, you may need two fields to have a given value
                    only when another field is present. Adding these validation rules doesn’t have to be a pain. First, create a Validator
                    instance with your static rules that never change

                    Let’s assume our web application is for game collectors. If a game collector registers with our application and they
                    own more than 100 games, we want them to explain why they own so many games. For example, perhaps they run a game
                    resale shop, or maybe they just enjoy collecting games. To conditionally add this requirement, we can use the sometimes
                    method on the Validator instance.

                    The first argument passed to the sometimes method is the name of the field we are conditionally validating. The second
                    argument is a list of the rules we want to add. If the closure passed as the third argument returns true, the rules
                    will be added. This method makes it a breeze to build complex conditional validations. You may even add conditional
                    validations for several fields at once

                    The $input parameter passed to your closure will be an instance of Illuminate\Support\Fluent and may be used to access
                    your input and files under validation.
                */
                $validate->sometimes('data_confirmation', 'required|string|ascii|min:10', function(Fluent $input) {
                    return $input->cek === "true";
                });

                /*
                    Complex Conditional Array Validation

                    Sometimes you may want to validate a field based on another field in the same nested array whose index you do not know.
                    In these situations, you may allow your closure to receive a second argument which will be the current individual item
                    in the array being validated

                    Like the $input parameter passed to the closure, the $item parameter is an instance of Illuminate\Support\Fluent when
                    the attribute data is an array; otherwise, it is a string.
                */
                $validate->sometimes('data.*.harga', 'required', function(Fluent $input, Fluent $item) {
                    return $item->varian === 'ekslusif';
                });

                if ($validate->fails()) {
                    $request->merge([
                        'data' => json_encode($request->input('data'))
                    ]);

                    return back()->withErrors($validate)->withInput();
                }

                $validate = $validate->validated();

                if (isset($validate['file_upload'])) {
                    $validate['file_upload'] = $validate['file_upload']->getClientOriginalName();
                }

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'required_array_keys':
                /*
                    The field under validation must be an array and must contain at least the specified keys.
                */
                $request->merge([
                    'data' => json_decode($request->input('data'), true)
                ]);

                $validate = Validator::make($request->all(), [
                    'data' => 'required_array_keys:nama,umur,data_diri,alamat'
                ]);

                if ($validate->fails()) {
                    $request->merge([
                        'data' => json_encode($request->input('data'))
                    ]);

                    return back()->withErrors($validate)->withInput();
                }

                $validate = $validate->validated();

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'validating arrays':
                /*
                    As discussed in the array validation rule documentation, the array rule accepts a list of allowed array keys.
                    If any additional keys are present within the array, validation will fail

                    In general, you should always specify the array keys that are allowed to be present within your array.
                    Otherwise, the validator's validate and validated methods will return all of the validated data, including
                    the array and all of its keys, even if those keys were not validated by other nested array validation rules.

                    Validating Nested Array Input
                    Validating nested array based form input fields doesn't have to be a pain. You may use "dot notation" to validate
                    attributes within an array. For example, if the incoming HTTP request contains a photos[profile] field, you may
                    validate it like so

                    You may also validate each element of an array. For example, to validate that each email in a given array input
                    field is unique, you may do the following

                    Likewise, you may use the * character when specifying custom validation messages in your language files, making
                    it a breeze to use a single validation message for array based fields

                    Accessing Nested Array Data
                    Sometimes you may need to access the value for a given nested array element when assigning validation rules to
                    the attribute. You may accomplish this using the Rule::forEach method. The forEach method accepts a closure
                    that will be invoked for each iteration of the array attribute under validation and will receive the attribute's
                    value and explicit, fully-expanded attribute name. The closure should return an array of rules to assign to the
                    array element

                    Error Message Indexes & Positions
                    When validating arrays, you may want to reference the index or position of a particular item that failed validation
                    within the error message displayed by your application. To accomplish this, you may include the :index (starts from 0)
                    and :position (starts from 1) placeholders within your custom validation message

                    If necessary, you may reference more deeply nested indexes and positions via
                    second-index, second-position, third-index, third-position, etc
                */
                if ($request->filled('data')) {
                    $request->merge([
                        'data' => json_decode($request->input('data'), true)
                    ]);
                }

                if ($request->filled('data_confirmation')) {
                    $request->merge([
                        'data_confirmation' => json_decode($request->input('data_confirmation'), true)
                    ]);
                }

                $validate = Validator::make($request->all(), [
                    // Dibawah ini adalah "key" yang boleh ada di dalam array (tapi tidak harus ada semua). Jika ada selain ini, maka validasi error
                    'data' => 'array:nama,umur,data_diri,makanan,tahu,risol',
                    'data_confirmation.username' => 'required|alpha_dash',
                    'data_confirmation.*.pesanan' => 'sometimes|array',
                    'data_confirmation.*.harga' => 'sometimes|integer',
                    'data_confirmation.info.*' => Rule::forEach(function($value, $attribute) {
                        if ($attribute === 'data_confirmation.info.os') {
                            return [
                                'array',
                                'min:1'
                            ];
                        } else {
                            return [
                                'array:merk,processor'
                            ];
                        }
                    }),
                    'data_confirmation.news.*.headline' => 'string',
                    'data_confirmation.news.*.views' => 'integer'
                ], [
                    'data_confirmation.*.pesanan' => [
                        'array' => 'Pesanan Harus Array'
                    ],
                    'data_confirmation.*.harga' => [
                        'required' => 'Harga Harus Ada',
                        'interger' => 'Harga Harus Bilangan Bulat'
                    ],
                    'data_confirmation.news.*.views' => [
                        'integer' => 'views ke-:index harus berupa integer'
                    ]
                ]);

                if ($validate->fails()) {
                    if ($request->filled('data')) {
                        $request->merge([
                            'data' => json_encode($request->input('data'))
                        ]);
                    }

                    if ($request->filled('data_confirmation')) {
                        $request->merge([
                            'data_confirmation' => json_encode($request->input('data_confirmation'))
                        ]);
                    }

                    return back()->withErrors($validate)->withInput();
                }

                $validate = $validate->validated();

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'validating files':
                /*
                    Laravel provides a variety of validation rules that may be used to validate uploaded files, such as
                    mimes, image, min, and max. While you are free to specify these rules individually when validating
                    files, Laravel also offers a fluent file validation rule builder that you may find convenient

                    If your application accepts images uploaded by your users, you may use the File rule's image constructor
                    method to indicate that the uploaded file should be an image. In addition, the dimensions rule may be used
                    to limit the dimensions of the image

                    More information regarding validating image dimensions may be found in the dimension rule documentation.

                    File Sizes
                    For convenience, minimum and maximum file sizes may be specified as a string with a suffix indicating the file
                    size units. The kb, mb, gb, and tb suffixes are supported

                    File Types
                    Even though you only need to specify the extensions when invoking the types method, this method actually validates
                    the MIME type of the file by reading the file's contents and guessing its MIME type. A full listing of MIME types
                    and their corresponding extensions may be found at the following location:
                    https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
                */
                $validate = $request->validate([
                    'file_upload' => ['required', File::image()->dimensions(Rule::dimensions()->ratio(16/9))->min(3000)->max(12000)]
                ]);
// File::types(['audio/mpeg', 'video/mp4', 'application/pdf', 'image/*'])->min(1000)->max(12000)
// File::image()->dimensions(Rule::dimensions()->ratio(16/9))->min(3000)->max(12000)
                $validate['file_upload'] = $validate['file_upload']->getClientOriginalName();

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'validating passwords':
                /*
                    To ensure that passwords have an adequate level of complexity, you may use Laravel's Password rule object

                    The Password rule object allows you to easily customize the password complexity requirements for your
                    application, such as specifying that passwords require at least one letter, number, symbol, or characters
                    with mixed casing

                    In addition, you may ensure that a password has not been compromised in a public password data breach leak
                    using the uncompromised method

                    Internally, the Password rule object uses the k-Anonymity model to determine if a password has been leaked
                    via the haveibeenpwned.com service without sacrificing the user's privacy or security.

                    By default, if a password appears at least once in a data leak, it will be considered compromised. You can
                    customize this threshold using the first argument of the uncompromised method

                    Of course, you may chain all the methods in the examples above
                */
                $validate = $request->validate([
                    'data' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()]
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            case 'custom validation rules':
                /*
                    Once the rule has been defined, you may attach it to a validator by passing an instance of the rule object with
                    your other validation rules
                */
                $validate = $request->validate([
                    'data' => ['required', new CustomRule],
                    'data_confirmation' => [
                        'required',
                        /*
                            Using Closures

                            If you only need the functionality of a custom rule once throughout your application, you may use a closure
                            instead of a rule object. The closure receives the attribute's name, the attribute's value, and a $fail
                            callback that should be called if validation fails
                        */
                        function(string $attribute, mixed $value, \Closure $fail) {
                            if (is_string($value) && !is_numeric($value)) {
                                $words = explode(' ', $value);

                                foreach ($words as $word) {
                                    if (ctype_lower($word[0])) {
                                        $fail('Every word in :attribute field must start with uppercase');
                                    }
                                }
                            } else {
                                $fail('The :attribute field must be a string');
                            }
                        }
                    ]
                ]);

                return back()->with('pass', ['Data Passes Validation', $validate]);
            default:
                return back()->withErrors(new MessageBag(['error_info' => 'Option is Not Valid']));
        }

        /*
            Implicit Rules

            By default, when an attribute being validated is not present or contains an empty string, normal validation rules, including
            custom rules, are not run. For example, the unique rule will not be run against an empty string

            For a custom rule to run even when an attribute is empty, the rule must imply that the attribute is required. To quickly
            generate a new implicit rule object, you may use the make:rule Artisan command with the --implicit option
            -> php artisan make:rule Uppercase --implicit

            An "implicit" rule only implies that the attribute is required. Whether it actually invalidates a missing or empty
            attribute is up to you.
        */
    }
}
