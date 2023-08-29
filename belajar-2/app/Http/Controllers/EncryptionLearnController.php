<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EncryptionLearnController extends Controller
{
    /*
        Introduction

        Laravel's encryption services provide a simple, convenient interface for encrypting and decrypting text via OpenSSL using
        AES-256 and AES-128 encryption. All of Laravel's encrypted values are signed using a message authentication code (MAC)
        so that their underlying value can not be modified or tampered with once encrypted.

        Configuration

        Before using Laravel's encrypter, you must set the key configuration option in your config/app.php configuration file. This
        configuration value is driven by the APP_KEY environment variable. You should use the php artisan key:generate command to
        generate this variable's value since the key:generate command will use PHP's secure random bytes generator to build
        a cryptographically secure key for your application. Typically, the value of the APP_KEY environment variable will be
        generated for you during Laravel's installation.

        Jika kita menjalankan perintah
        -> php artisan key:generate

        Jika nilai APP_KEY berubah maka kunci message authentication code (MAC) akan menjadi tidak valid, jadi sebelum menggunakan
        fitur ini pastikan APP_KEY di file .env tidak pernah berubah
    */
    public function encryption_controller(Request $request) {
        $data = [
            'title' => 'Encryption'
        ];

        // Get the encryption key that the encrypter is currently using.
        $data['crypt_key'] = base64_encode(Crypt::getKey());

        $key = random_bytes(32);
        $cipher = 'AES-256-CBC';

        // Determine if the given key and cipher combination is valid.
        if (Crypt::supported($key, $cipher)) {
            $data['generated_key'] = base64_encode($key);
        } else {
            $data['generated_key'] = 'Generated Key Is Not Supported';
        }

        // Create a new encryption key for the given cipher.
        $data['generated_key2'] = base64_encode(Crypt::generateKey($cipher));

        return view('belajar.encryption', $data);
    }

    public function encryption_process_controller(Request $request) {
        if ($request->filled('input')) {
            if ($request->input('option') === 'encrypt') {
                /*
                    Encrypting A Value

                    You may encrypt a value using the encryptString method provided by the Crypt facade. All encrypted values are
                    encrypted using OpenSSL and the AES-256-CBC cipher. Furthermore, all encrypted values are signed with a message
                    authentication code (MAC). The integrated message authentication code will prevent the decryption of any values
                    that have been tampered with by malicious users
                */

                // Encrypt a string without serialization.
                // $encrypt = Crypt::encryptString($request->input('input'));

                // Sama seperti diatas tapi tersedia argumen kedua jika ingin melakukan serialize atau tidak
                $encrypt = Crypt::encrypt($request->input('input'), $request->boolean('serialize'));

                return redirect('/belajar-laravel/encryption')->with(['text' => $request->input('input'), 'encrypt' => $encrypt]);
            } else if ($request->input('option') === 'decrypt') {
                /*
                    Decrypting A Value

                    You may decrypt values using the decryptString method provided by the Crypt facade. If the value can not be properly
                    decrypted, such as when the message authentication code is invalid, an Illuminate\Contracts\Encryption\DecryptException
                    will be thrown
                */

                // Decrypt the given string without unserialization.
                // $decrypt = Crypt::decryptString($request->input('input'));

                // Sama seperti diatas tapi tersedia argumen kedua jika ingin melakukan unserialize atau tidak
                $decrypt = Crypt::decrypt($request->input('input'), $request->boolean('serialize'));

                return redirect('/belajar-laravel/encryption')->with(['text' => $request->input('input'), 'decrypt' => $decrypt]);
            } else {
                return back()->with('error', 'Option Invalid')->withInput();
            }
        } else {
            return back()->with('error', 'Form Must Be Filled')->withInput();
        }
    }

    // Jika ingin membuat instance-nya sendiri, silahkan buat dengan class Illuminate\Encryption\Encrypter
}
