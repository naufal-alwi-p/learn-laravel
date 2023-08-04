<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home_controller() {
        $data = [
            'title' => 'Homepage',
            'home_nav' => true
        ];

        $data['posts'] = Post::latest('updated_at')->get();

        return view('home', $data);
    }
}
