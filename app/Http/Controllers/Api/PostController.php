<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private function getPostImgSrc($post)
    {
        $toReturn = null;

        if ($post->image_path) {
            $toReturn = asset("storage/" . $post->image_path);
        } else {
        }

        return $toReturn;
    }

    public function index()
    {
        $posts = Post::paginate(4);

        $posts->map(function ($post) {

            $post->image_path = $this->getPostImgSrc($post);

            return $post;
        });

        return response()->json($posts);
    }

    public function show($slug) {
        $post = Post::where("slug", $slug)->first();

        $post->load("category", "tags", "user:id,name");

        $post->image_path = Storage::url($post->image_path);

        return response()->json($post);
    }
}
