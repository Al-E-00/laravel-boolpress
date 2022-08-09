<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * It return an element searching for its slug
     * If the element is not found an error 404 it's launched
     */
    private function findBySlug($slug) {
        $post = Post::where('slug', $slug)->first();

        if(!$post) {
            abort(404);
        }

        return $post;
    }

    private function generateSlug($text) {
        $toReturn = null;
        $counter = 0;
        
        do {
            //slug generated from title
            $slug = Str::slug($text);

            //if counter > 0, concatenate its value at the slug
            if($counter > 0) {
                $slug .= '-' . $counter;
            }

            //check db if a similar slug exists
            $slug_exists = Post::where('slug', $slug)->first();
            //if exists, the counter is incremented
            if ($slug_exists) {
                $counter++;
            } else {
                //else I save the slug into the new post data
                $toReturn = $slug;
            }
        } while ($slug_exists);

        return $toReturn;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
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
            'title'=>'required|min:10',
            'content'=>'required|min:15'
        ]);

        $post = new Post();
        $post->fill($validatedData);

        $post->slug = $this->generateSlug($post->title);

        $post->save();

        return redirect()->route('admin.posts.show', $post->slug);
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

        return view('admin.posts.show', compact('post'));
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
        
        return view('admin.posts.edit', compact('post'));
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
            'title'=>'required|min:10',
            'content'=>'required|min:15'
        ]);

        $post = $this->findBySlug($slug);

        if($validatedData['title'] !== $post->title) {
            $post->slug = $this->generateSlug($validatedData['title']);
        }

        $post->update($validatedData);

        return redirect()->route('admin.posts.show', $post->slug);

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
    }
}
