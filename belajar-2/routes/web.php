<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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
});
