<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HashLearnController extends Controller
{
    /*
        Introduction

        The Laravel Hash facade provides secure Bcrypt and Argon2 hashing for storing user passwords. If you are using one of the Laravel
        application starter kits, Bcrypt will be used for registration and authentication by default.

        Bcrypt is a great choice for hashing passwords because its “work factor” is adjustable, which means that the time it takes to
        generate a hash can be increased as hardware power increases. When hashing passwords, slow is good. The longer an algorithm
        takes to hash a password, the longer it takes malicious users to generate “rainbow tables” of all possible string hash values
        that may be used in brute force attacks against applications.

        Configuration

        The default hashing driver for your application is configured in your application’s config/hashing.php configuration file. There
        are currently several supported drivers: Bcrypt and Argon2 (Argon2i and Argon2id variants).
    */
    public function hash_controller() {
        $data = [
            'title' => 'Hash'
        ];

        return view('belajar.hash', $data);
    }

    public function hash_process_controller(Request $request) {
        $redirect = redirect('/belajar-laravel/hash');

        if ($request->filled(['nama', 'username', 'email', 'pw', 'opsi'])) {
            switch ($request->input('opsi')) {
                case 'new_account':
                    $new_user = new User;
                    $new_user->name = $request->input('nama');
                    $new_user->username = $request->input('username');
                    $new_user->email = $request->input('email');
                    $new_user->email_verified_at = now('Asia/Jakarta');

                    /*
                        - Hashing Passwords
                        You may hash a password by calling the make method on the Hash facade
                        
                        - Adjusting The Bcrypt Work Factor
                        If you are using the Bcrypt algorithm, the make method allows you to manage the work factor of the algorithm
                        using the rounds option; however, the default work factor managed by Laravel is acceptable for most applications

                        - Adjusting The Argon2 Work Factor
                        If you are using the Argon2 algorithm, the make method allows you to manage the work factor of the algorithm using
                        the memory, time, and threads options; however, the default values managed by Laravel are acceptable for most applications
                        
                        For more information on these options, please refer to the official PHP documentation regarding Argon hashing.
                    */

                    $new_user->password = Hash::make($request->input('pw'), ['rounds' => $request->integer('work_factor')]);

                    if ($new_user->save()) {
                        return $redirect->with('success', 'Data Berhasil Disimpan');
                    } else {
                        return back()->withInput($request->except('pw'))->with('error', 'Data Gagal Disimpan');
                    }

                case 'login':
                    $user = User::firstWhere('username', $request->input('username'));

                    $check = $user !== null && $request->input('nama') === $user->name &&
                            $request->input('email') === $user->email;

                    if (!$check) {
                        return back()->with('error', 'Gagal Login');
                    }

                    /*
                        Verifying That A Password Matches A Hash

                        The check method provided by the Hash facade allows you to verify that a given plain-text string
                        corresponds to a given hash
                    */
                    if (Hash::check($request->input('pw'), $user->password)) {
                        return $redirect->with('success', 'Login Berhasil');
                    } else {
                        return back()->with('error', 'Gagal Login');
                    }

                case 'check_rehash':
                    $user = User::firstWhere('username', $request->input('username'));

                    $check = $user !== null && $request->input('nama') === $user->name &&
                            $request->input('email') === $user->email &&
                            Hash::check($request->input('pw'), $user->password, ['rounds' => $request->integer('work_factor')]);

                    if (!$check) {
                        return back()->with('error', 'Gagal Login');
                    }

                    /*
                        Determining If A Password Needs To Be Rehashed

                        The needsRehash method provided by the Hash facade allows you to determine if the work factor used by the hasher has
                        changed since the password was hashed. Some applications choose to perform this check during the application's
                        authentication process
                    */

                    if (Hash::needsRehash($user->password, ['rounds' => $request->integer('work_factor')])) {
                        return $redirect->with('error', 'Password Perlu Direhash')->withInput();
                    } else {
                        return back()->with('success', 'Password Tidak Perlu Direhash')->withInput();
                    }

                case 'rehash':
                    $user = User::firstWhere('username', $request->input('username'));

                    $check = $user !== null && $request->input('nama') === $user->name &&
                            $request->input('email') === $user->email &&
                            Hash::check($request->input('pw'), $user->password, ['rounds' => $request->integer('work_factor')]);

                    if (!$check) {
                        return back()->with('error', 'Gagal Login');
                    }

                    if (Hash::needsRehash($user->password, ['rounds' => $request->integer('work_factor')])) {
                        $user->password = Hash::make($request->input('pw'), ['rounds' => $request->integer('work_factor')]);

                        if ($user->save()) {
                            return $redirect->with('success', 'Berhasil Rehash Password');
                        } else {
                            return back()->with('error', 'Gagal Menyimpan Data')->withInput();
                        }
                    } else {
                        return back()->with('success', 'Password Tidak Perlu Direhash')->withInput();
                    }

                case 'info':
                    $user = User::firstWhere('username', $request->input('username'));

                    $check = $user !== null && $request->input('nama') === $user->name &&
                            $request->input('email') === $user->email &&
                            Hash::check($request->input('pw'), $user->password, ['rounds' => $request->integer('work_factor')]);

                    if (!$check) {
                        return back()->with('error', 'Gagal Login');
                    }

                    $redirect->with('info', [
                        Hash::info($user->password), // Get information about the given hashed value.
                        Hash::isHashed($user->password), // Determine if a given string is already hashed.
                        Hash::getDefaultDriver(), // Get the default driver name.
                        Hash::getDrivers() // Get all of the created "drivers".
                    ]);

                    return $redirect->withInput();
                    
                default:
                    return back()->with('error', 'The Option Is Invalid');
            }
            
        } else {
            return back()->withInput($request->except('pw'))->with('error', 'Isi Semua Form');
        }
    }
}
