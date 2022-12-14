<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    private function findBySlug($slug)
    {
        $post = Post::where("slug", $slug)->first();

        if (!$post) {
            abort(404);
        }

        return $post;
    }

    private function generateSlug($text)
    {
        $toReturn = null;
        $counter = 0;

        do {
            $slug = Str::slug($text);

            if ($counter > 0) {
                $slug .= "-" . $counter;
            }

            $slug_esiste = Post::where("slug", $slug)->first();

            if ($slug_esiste) {
                $counter++;
            } else {
                $toReturn = $slug;
            }
        } while ($slug_esiste);

        return $toReturn;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === "admin") {
            $posts = Post::orderBy("created_at", "desc")->get();
        } else {
            $posts = $user->posts;
        }

        return view("admin.posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view("admin.posts.create", compact("categories", "tags"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            "title" => "required|min:10",
            "content" => "required|min:10",
            "category_id" => "nullable|exists:categories,id",
            "tags" => "nullable|exists:tags,id",
            "image_path"=>"required|mimes:jpg,jpeg,gif,svg,png"
        ]);


        $post = new Post();
        $post->fill($validatedData);
        $post->user_id = Auth::user()->id;


        $filePath = Storage::put("/", $validatedData["image_path"]);

        $post->image_path = $filePath;

        $post->slug = $this->generateSlug($post->title);

        $post->save();

        if (key_exists("tags", $validatedData)) {
            $post->tags()->attach($validatedData["tags"]);
        }

        return redirect()->route("admin.posts.show", $post->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = $this->findBySlug($slug);

        return view("admin.posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = $this->findBySlug($slug);
        $categories = Category::all();
        $tags = Tag::all();

        return view("admin.posts.edit", compact("post", "categories", "tags"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $validatedData = $request->validate([
            "title" => "required|min:10",
            "content" => "required|min:10",
            "category_id" => "nullable|exists:categories,id",
            "tags" => "nullable|exists:tags,id",
            "image_path"=> "nullable|mimes:jpg,jpeg,gif,svg,png"
        ]);
        $post = $this->findBySlug($slug);

        if ($validatedData["title"] !== $post->title) {
            $post->slug = $this->generateSlug($validatedData["title"]);
        }
        if (key_exists("tags", $validatedData)) {
            $post->tags()->sync($validatedData["tags"]);
        } else {
            $post->tags()->sync([]);
        }

        //post image delete -> from public folder->
        // then update of the new one
        Storage::delete($post->image_path);

        $file = $validatedData["image_path"];
        $filePath = Storage::put("/", $file);

        $post->image_path = $filePath;

        $post->update($validatedData);

        return redirect()->route("admin.posts.show", $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = $this->findBySlug($slug);

        $post->tags()->detach();

        Storage::delete($post->image_path);

        $post->delete();

        return redirect()->route("admin.posts.index");
    }
}
