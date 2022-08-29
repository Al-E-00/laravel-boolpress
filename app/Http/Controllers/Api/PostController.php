<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();

        $posts = $posts->map(function($post){

            if($post->image_path) {
                $post->image_path = asset("storage/" . $post->image_path);
            } else {
                //$post->image_path = asset("images/placeholder.webp");
            }
            return $post;
        });


        return response()->json($posts);
    }
}
