<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EncryptionLearnController;
use App\Http\Controllers\FileStorageLearnController;
use App\Http\Controllers\HashLearnController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RequestLearnController;
use App\Http\Controllers\ResponseLearnController;
use App\Http\Controllers\SessionLearnController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'home_controller'])->name('homepage');

Route::get('/post/{post:slug}', [PostController::class, 'post_page_controller']);

Route::get('/category/{kategori:slug}', [CategoryController::class, 'category_controller']);

Route::get('/author/{author:username}', [AuthorController::class, 'author_post_controller']);

Route::post('/search-post', [PostController::class, 'search_post_controller']);

Route::post('/search-post-category', [CategoryController::class, 'search_post_category_controller']);

Route::post('/search-post-author', [AuthorController::class, 'search_post_author_category']);

Route::get('/new-post', [PostController::class, 'new_post_controller']);

Route::post('/new-post-handler', [PostController::class, 'new_post_handler_controller']);

Route::get('/categories', [CategoryController::class, 'categories_controller']);

// Buat Belajar Materi Laravel
Route::prefix('belajar-laravel')->group(function() {
    Route::get('/', [HomeController::class, 'belajar_index_controller']); // "/belajar-laravel"

    Route::get('/session', [SessionLearnController::class, 'belajar_session_controller']); // "/belajar-laravel/session"

    // Belajar Response Laravel
    Route::get('/response', [ResponseLearnController::class, 'response_index_controller']); // "/belajar-laravel/response"

    Route::prefix('response')->group(function() {
        Route::get('/string', [ResponseLearnController::class, 'response_string_controller']); // "/belajar-laravel/response/string"

        Route::get('/array', [ResponseLearnController::class, 'response_array_controller']); // "/belajar=laravel/response/array"

        Route::get('/eloquent', [ResponseLearnController::class, 'response_eloquent_controller']);

        Route::get('/response-object', [ResponseLearnController::class, 'response_object_controller']);

        Route::get('/set-cookie', [ResponseLearnController::class, 'response_set_cookie_controller']);

        Route::get('/delete-cookie', [ResponseLearnController::class, 'response_delete_cookie_controller']);

        Route::get('/redirect-response', [ResponseLearnController::class, 'redirect_response_controller']);

        Route::get('/redirect-to-named-route', [ResponseLearnController::class, 'redirect_to_named_route']);

        Route::get('/redirect-to-controller-action', [ResponseLearnController::class, 'redirect_to_controller_action']);

        Route::get('/target-redirected-action-controller', [ResponseLearnController::class, 'target_redirect_controller']);

        Route::get('/redirect-to-naufaldev', [ResponseLearnController::class, 'redirect_to_external_domain_controller']);

        Route::get('/form-data', [ResponseLearnController::class, 'form_get_method_controller']);

        Route::post('/form-data', [ResponseLearnController::class, 'form_post_method_controller']);

        Route::get('/json-response', [ResponseLearnController::class, 'json_response_controller']);

        Route::get('/jsonp-response', [ResponseLearnController::class, 'jsop_response_controller']);

        Route::get('/download-file', [ResponseLearnController::class, 'download_file_controller']);

        Route::get('/file-response', [ResponseLearnController::class, 'file_response_controller']);
    });

    // Belajar Request Laravel
    Route::get('/request', [RequestLearnController::class, 'request_index_controller']);

    Route::prefix('/request')->group(function() {
        Route::get('/accessing-request-http', [RequestLearnController::class, 'accessing_request_controller']);

        Route::get('/form-input-request-http', [RequestLearnController::class, 'form_input_request_controller']);

        Route::post('/form-input-request-http', [RequestLearnController::class, 'form_input_result_controller']);
    });

    // Belajar File Storage Laravel
    Route::get('/file-storage', [FileStorageLearnController::class, 'file_storage_index_controller']);

    Route::prefix('file-storage')->group(function() {
        Route::get('/local-disk', [FileStorageLearnController::class, 'local_disk_controller']);

        Route::get('/public-disk', [FileStorageLearnController::class, 'public_disk_controller']);

        Route::get('/general', [FileStorageLearnController::class, 'general_storage_controller']);

        Route::get('/download-file', [FileStorageLearnController::class, 'download_file_controller']);

        // Permasalahan yang terjadi yaitu, video tidak bisa lompat ke timestamp yang diinginkan
        // Penjelasan Masalah Lebih Detail: https://stackoverflow.com/questions/8088364/html5-video-will-not-loop
        Route::get('/video-response-for-chrome/{filename}', [FileStorageLearnController::class, 'video_response_for_chrome_controller'])->name('file.video-response-for-chrome');

        Route::get('/form-file-upload', [FileStorageLearnController::class, 'form_file_display_controller'])->name('file.form');

        Route::post('/form-file-upload', [FileStorageLearnController::class, 'form_file_process_controller']);

        Route::get('/uploaded-file-display', [FileStorageLearnController::class, 'uploaded_file_display'])->name('file.uploaded_display');

        Route::get('/delete-uploaded-file/{filename}', [FileStorageLearnController::class, 'delete_uploaded_file'])->name('file.uploaded_delete');

        Route::get('/form-upload-dropbox', [FileStorageLearnController::class, 'form_upload_dropbox_controller'])->name('file.dropbox_form');

        Route::post('/form-upload-dropbox', [FileStorageLearnController::class, 'form_process_dropbox_controller']);

        Route::get('/dropbox-display', [FileStorageLearnController::class, 'dropbox_file_controller'])->name('file.display_dropbox_file');

        Route::get('/dropbox-file-uploaded-response/{mime}/{filename}', [FileStorageLearnController::class, 'dropbox_file_uploaded_response_controller'])->name('file.dropbox_file');

        Route::delete('/delete-dropbox-uploaded-file', [FileStorageLearnController::class, 'delete_dropbox_uploaded_file_controller']);
    });

    // Belajar Encryption Laravel
    Route::get('/encryption', [EncryptionLearnController::class, 'encryption_controller']);

    Route::post('/encryption', [EncryptionLearnController::class, 'encryption_process_controller']);

    // Belajar Hash Laravel
    Route::get('/hash', [HashLearnController::class, 'hash_controller']);

    Route::post('/hash', [HashLearnController::class, 'hash_process_controller']);
});
