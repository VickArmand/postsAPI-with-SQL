<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate(
            [
                'title'=>'required|string|max:100',
                'body'=>'required|string|max:300'
            ]);
            // $msg = Post::create($request->all()) ? ["Post created"] : ["Post creation failed"];
            // return $msg;

            $post = new Post();
            $post->title = $request->title;
            $post->slug = Str::slug($request->title, '-');
            $post->body = $request->body;
            $msg = $post->save() ? ["Success" => "Post created"] : ["Error" => "Post creation failed"];
            return $msg;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        return $id ? Post::find($id): ["Post not found"];
    }
    public function search(string $slug = null)
    {
        return $slug ? Post::where('slug', 'like', '%'.$slug.'%')->get() : ["Post not found"];
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id = null)
    {
        $request->validate(
            [
                'title'=>'string|max:100',
                'slug'=>'string|max:100',
                'body'=>'string|max:300'
            ]);
        $post = $id ? Post::find($id) : null;
        if ($post)
        {
            $msg = $post->update($request->all()) ? ["Post updated"] : ["Post Updation failed"];;
        }
        else
        {
            $msg = ["Post not found"];
        }
        return ($msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id = null)
    {
        $post = $id ? Post::find($id) : null;
        if ($post)
        {
            $msg = $post->delete() ? ["Post deleted"] : ["Deletion failed"];
        }
        else
        {
            $msg = ["Post not found"];
        }
        return $msg;
    }
}
