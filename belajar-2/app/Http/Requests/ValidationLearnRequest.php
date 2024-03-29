<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ValidationLearnRequest extends FormRequest
{
    /*
        Form Request Validation

        Creating Form Requests

        For more complex validation scenarios, you may wish to create a "form request". Form requests are custom request classes that encapsulate
        their own validation and authorization logic. To create a form request class, you may use the make:request Artisan CLI command
        -> php artisan make:request ValidationLearnRequest

        The generated form request class will be placed in the app/Http/Requests directory. If this directory does not exist, it will be created
        when you run the make:request command. Each form request generated by Laravel has two methods: authorize and rules.

        As you might have guessed, the authorize method is responsible for determining if the currently authenticated user can perform the
        action represented by the request, while the rules method returns the validation rules that should apply to the request's data

        You may type-hint any dependencies you require within the rules method's signature. They will automatically be resolved via
        the Laravel service container.
    */

    /*
        If you plan to handle authorization logic for the request in another part of your application, you may simply return true from
        the authorize method
    */
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|ascii',
            'email' => 'required|email:rfc,dns,spoof',
            'daftar' => 'required|after:2022-01-05|before:today'
        ];
    }

    /*
        Performing Additional Validation

        Sometimes you need to perform additional validation after your initial validation is complete. You can accomplish this using
        the form request's after method.

        The after method should return an array of callables or closures which will be invoked after validation is complete. The
        given callables will receive an Illuminate\Validation\Validator instance, allowing you to raise additional error
        messages if necessary

        As noted, the array returned by the after method may also contain invokable classes. The __invoke method of these classes
        will receive an Illuminate\Validation\Validator instance

        Jika validasi utama gagal, method after() tidak akan dipanggil
        Harus ada perlakuan khusus jika ingin menggunakan method after() dengan custom redirect
    */

    /**
     * Perform additional validation after the initial validation is complete
     */
    public function after() {
        return [
            function(Validator $validator) {
                $nama = explode(' ', $this->validated('nama'));

                foreach ($nama as $word) {
                    if (ctype_lower($word[0])) {
                        $validator->errors()->add(
                            'nama',
                            'Nama harus diawali huruf kapital per kata'
                        );
                        break;
                    }
                }

                if ($this->validated('email') === 'arknet@gmail.com') {
                    $validator->errors()->add(
                        'email',
                        'Arknet game gw woy >:('
                    );
                }

                // Harus ada perlakuan khusus jika ingin menggunakan method after() dengan custom redirect
                if ($validator->errors()->any()) {
                    $this->failedValidation($validator);
                }
            }
        ];
    }

    /*
        Stopping On The First Validation Failure

        By adding a stopOnFirstFailure property to your request class, you may inform the validator that it should stop validating all
        attributes once a single validation failure has occurred
    */

    protected $stopOnFirstFailure = false;

    /*
        Customizing The Redirect Location

        As previously discussed, a redirect response will be generated to send the user back to their previous location when form request
        validation fails. However, you are free to customize this behavior. To do so, define a $redirect property on your form request

        Harus ada perlakuan khusus jika ingin menggunakan method after() dengan custom redirect
    */
    protected $redirect = '/belajar-laravel';

    /*
        Or, if you would like to redirect users to a named route, you may define a $redirectRoute property instead
    */
    // protected $redirectRoute = 'file.form';

    /*
        Customizing The Error Messages

        You may customize the error messages used by the form request by overriding the messages method. This method should return an
        array of attribute / rule pairs and their corresponding error messages
    */

    /**
     * Customize the error messages used by the form request
     * 
     * @return array
     */
    public function messages(): array {
        return [
            // 1 atribut per aturan
            'nama.required' => ':attribute gak boleh kosong',
            'nama.ascii' => ':input bukan karakter ascii',
            // 1 atribut untuk semua aturan
            'email' => 'Bagian :attribute yang bener isinya',

            'daftar.required' => 'Isi :attribute',
            'daftar.after' => 'Tanggal pendaftaran harus setelah 5 Januari 2022',
            'daftar.before' => 'Tanggal pendaftaran harus sebelum hari ini'
        ];
    }

    /*
        Customizing The Validation Attributes

        Many of Laravel's built-in validation rule error messages contain an :attribute placeholder. If you would like the :attribute
        placeholder of your validation message to be replaced with a custom attribute name, you may specify the custom names by
        overriding the attributes method. This method should return an array of attribute / name pairs
    */

    /**
     * Replace the default :attribute placeholder with a custom attribute name
     * 
     * @return array
     */
    public function attributes() {
        return [
            'nama' => 'input nama',
            'email' => 'input email',
            'daftar' => 'input tanggal pendaftaran'
        ];
    }

    /*
        Preparing Input For Validation

        If you need to prepare or sanitize any data from the request before you apply your validation rules, you may use the
        prepareForValidation method
    */

    /**
     * Prepare or sanitize any data from the request before applying the validation rules
     */
    public function prepareForValidation() {
        $email = explode('@', $this->input('email'));
        $email[0] .= '7ujuh';
        $email = implode('@', $email);

        $this->merge([
            'email' => $email
        ]);
    }

    /*
        Likewise, if you need to normalize any request data after validation is complete, you may use the passedValidation method
    */

    /**
     * Normalize any request data after validation is complete
     */
    public function passedValidation() {
        $email = explode('@', $this->input('email'));
        $email[0] .= 'Uzumaki';
        $email = implode('@', $email);

        $this->merge([
            'email' => $email
        ]);
    }
}
