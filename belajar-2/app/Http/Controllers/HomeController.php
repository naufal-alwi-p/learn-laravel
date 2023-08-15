<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function home_controller() {
        $data = [
            'title' => 'Homepage',
            'home_nav' => true
        ];

        $data['posts'] = Post::with(['user', 'category'])->latest('updated_at')->get();

        return view('home', $data);
    }

    public function belajar_index_controller() {
        $listRoute = collect(Route::getRoutes()->getRoutesByMethod()['GET']);

        $data = [
            'title' => 'Daftar Isi',
            'links' => $listRoute->filter(fn($route) => ($route->getPrefix() === '/belajar-laravel'))->values()->skip(1)->all()
        ];

        return view('belajar.index', $data);
    }
}
