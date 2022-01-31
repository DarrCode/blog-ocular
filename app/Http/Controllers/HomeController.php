<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Post, Comment};

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $posts = Post::where('published', true)->orderByDesc('created_at')->get();
        return $posts->toJson();
    }

    public function show(Post $post, Request $request) {
        if($request->ajax()) {
            return $post;
        }

        $check = \Auth::check();

        if(isset($request->guest)) {
            return view('index', compact('post', 'check'));
        }

        return view('welcome', compact('check'));
    }

    public function countVisit(Request $request) {
        $post = Post::find($request->id);
        $post->update([
            'visits' => $post->visits + 1
        ]);
    }
}
