<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostRequest;
use App\Models\Post;

class HomeController extends Controller
{
    public function index() {
        $posts = Post::orderByDesc('created_at')->get();
        return $posts->toJson();
    }

    public function store(PostRequest $request) {
        $user = auth()->user();
        
        $post              = new Post();
        $post->title       = $request->title;
        $post->author      = $request->author;
        $post->slug        = $request->slug;
        $post->description = $request->description;
        $post->published   = $request->published == 'true' ? 1 : 0;
        $post->image       = $this->upload($request->file('image'));
        $post->user_id     = $user->id;

        $post->save();

        return 'ok';
    }

    private function upload($image)
    {
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'images/post';

        $rename = uniqid() . '.' . $path_info['extension'];
        $image->move(public_path() . "/$post_path", $rename);
        return "$post_path/$rename";
    }

    public function update(Post $post, PostRequest $request) {
        $user = auth()->user();

        if($request->hasFile('image')) {
            if($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path           = $request->file('image')->store('public/img/posts');
            $request->image = explode('public/', $path)[1];
        }

        $post->update([
            'title'         => $request->title,
            'author'        => $request->author,
            'slug'          => $request->slug,
            'description'   => $request->description,
            'image'         => $request->image,
            'published'     => $request->published == 'true' ? 1 : 0,
            'user_id'       => $user->id
        ]);

        return 'ok';
    }

    public function destroy(Post $post) {
        if($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return 'ok';
    }

    public function allVisits() {
        $posts  = Post::get();
        $data   = collect();

        foreach ($posts as $post) {
            $data->push([
               'name'   => $post->title,
               'y'      => $post->visits
            ]);
        }

        return $data->toJson();
    }
}
