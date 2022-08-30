<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

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
}
