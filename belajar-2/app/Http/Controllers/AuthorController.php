<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function author_post_controller(User $author) {
        $data = [
            'title' => $author->name,
            'posts' => $author->posts()->with('category')->latest()->get()
        ];

        return view('author', $data);
    }

    public function search_post_author_category(Request $request) {
        if($request->isJson()) {
            $query = $request->input('query');
            $userName = $request->input('username');

            $author = User::where('username', $userName)->first()->id;

            $hasil = DB::table('posts')->join('categories', 'posts.category_id', '=', 'categories.id')
                            ->select('categories.category', 'categories.slug as category_slug', 'posts.slug as post_slug', 'posts.title', 'posts.excerpt', 'posts.updated_at')
                            ->where('posts.user_id', $author)
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
