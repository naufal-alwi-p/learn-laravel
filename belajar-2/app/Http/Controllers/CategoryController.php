<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category_controller(Category $kategori) {
        $data = [
            'title' => $kategori->category,
            'posts' => $kategori->posts()->with('user')->latest()->get()
        ];

        return view('category', $data);
    }

    public function categories_controller() {
        $data = [
            'title' => "Categories",
            'categories_nav' => true,
            'categories' => Category::all()
        ];

        return view('categories', $data);
    }

    public function search_post_category_controller(Request $request) {
        if($request->isJson()) {
            $query = $request->input('query');
            $slugkategori = $request->input('category');

            $kategori = Category::where('slug', $slugkategori)->first()->id;

            $hasil = DB::table('posts')->join('users', 'posts.user_id', '=', 'users.id')
                            ->select('users.name', 'users.username', 'posts.slug as post_slug', 'posts.title', 'posts.excerpt', 'posts.updated_at')
                            ->where('posts.category_id', $kategori)
                            ->where('posts.title', 'like', "%$query%")
                            ->orderBy('posts.updated_at', 'desc')
                            ->get()
                            ->all();

            foreach($hasil as $value) {
                $value->updated_at = Carbon::createFromTimeString($value->updated_at)->diffForHumans();
            }

            return response()->json([
                'result' => $hasil
            ]);
        } else {
            return response(status: 404);
        }
    }
}
