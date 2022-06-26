<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {

        // $posts = Post::paginate(20);

        //eager loading to reduce page queries
         $posts = Post::orderBy('created_at','desc')->with(['user', 'likes'])->paginate(20);

        // arrange post based on time shortcut method
        // $posts = Post::latest()->with(['user', 'likes'])->paginate(20);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {
        //validate
        $this->validate($request,[

            'body' => 'required'
        ]);

        //create post

        // Post::create([
        //     'user_id' => auth()->user()->id,
        //     'body' => $request->body
        // ]);
            //we can use this or the code below
    //    // $request->user()->posts()->create([
    //         'body' => $request->body
    //     ]);

         $request->user()->posts()->create($request->only('body'));

        return back();
    }


    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }

}
