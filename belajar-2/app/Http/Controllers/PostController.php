<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function post_page_controller(Post $post) {
        $data = [
            'title' => $post->title,
            'post' => $post
        ];

        return view('post', $data);
    }

    public function search_post_controller(Request $request) {
        if($request->isJson()) {
            $query = $request->input('query');

            $hasil = DB::table('posts')->join('users', 'posts.user_id', '=', 'users.id')
                            ->join('categories', 'posts.category_id', '=', 'categories.id')
                            ->select('users.name', 'users.username', 'categories.category', 'categories.slug as category_slug', 'posts.slug as post_slug', 'posts.title', 'posts.excerpt', 'posts.updated_at')
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

    public function new_post_controller() {
        $data = [
            'title' => 'Create New Post',
            'new_post_nav' => true,
            'authors' => User::all(),
            'categories' => Category::all()
        ];

        return view('post_form', $data);
    }

    public function new_post_handler_controller(Request $request) {
        if($request->filled(['title', 'author', 'category', 'content'])) {
            try {
                DB::transaction(function () use ($request) {
                    $user = User::where('name', $request->input('author'))->firstOr(function() use ($request) {
                        return User::create([
                            'name' => $request->input('author'),
                            'username' => Str::studly($request->input('author')),
                            'email' => fake()->unique()->safeEmail(),
                            'email_verified_at' => now(),
                            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                            'remember_token' => Str::random(10)
                        ]);
                    });
        
                    $category = Category::firstOrCreate([
                        'category' => $request->input('category'),
                        'slug' => Str::slug($request->input('category'))
                    ]);
        
                    $post = new Post;
                    $post->user_id = $user->id;
                    $post->category_id = $category->id;
                    $post->title = $request->input('title');
                    $post->slug = Str::slug($request->input('title')) . '-' . fake()->numerify();

                    $teks = collect(explode("\r\n", $request->input('content')))->reject(fn($value) => empty($value))->all();

                    $post->body = implode("\n", $teks);
                    $post->excerpt = Str::words(implode(" ", $teks), random_int(40, 60));
        
                    $post->save();
                });
            } catch (\Throwable $th) {
                $data = [
                    'title' => 'Create New Post',
                    'authors' => User::all(),
                    'categories' => Category::all(),
                    'error' => $th
                ];
        
                return view('post_form', $data);
            }

            return redirect('/');
        } else {
            return back();
        }
    }
}
