<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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

Route::get('/', [HomeController::class, 'home_controller']);

Route::get('/post/{post:slug}', [PostController::class, 'post_page_controller']);

Route::get('/category/{kategori:slug}', [CategoryController::class, 'category_controller']);

Route::get('/author/{author:username}', [AuthorController::class, 'author_post_controller']);

Route::post('/search-post', [PostController::class, 'search_post_controller']);

Route::post('/search-post-category', [CategoryController::class, 'search_post_category_controller']);

Route::post('/search-post-author', [AuthorController::class, 'search_post_author_category']);

Route::get('/new-post', [PostController::class, 'new_post_controller']);

Route::post('/new-post-handler', [PostController::class, 'new_post_handler_controller']);

Route::get('/categories', [CategoryController::class, 'categories_controller']);
