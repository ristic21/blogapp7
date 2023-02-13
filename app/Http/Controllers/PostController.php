<?php

namespace App\Http\Controllers;

use App\Mail\DeleteMail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('is_deleted', false)->paginate(10);
        foreach ($posts as $post) {
            $post->body = substr($post->body, 0, 100) . '...';
        }
        return view('posts', compact('posts'));
    }

    public function index2()
    {
        $posts = Post::where('is_deleted', false)->paginate(5);
        foreach ($posts as $post) {
            $post->body = substr($post->body, 0, 100) . '...';
        }
        return view('postdashboard', compact('posts'));
    }

    public function index3() {
        $posts = Post::where('is_deleted', true)->paginate(5);
        foreach ($posts as $post) {
            $post->body = substr($post->body, 0, 100) . '...';
        }
        return view('deletedposts', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2|max:100|string',
            'body' => 'required|min:10|max:2000|string'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return redirect('createpost')->with('status', 'Post successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('comments')->find($id);
        // $post->comments = $post->comments();
        return view('post', compact('post'));
    }

    public function showEdit($id) {
        $post = Post::find($id)->paginate(10);
        
        return view('post', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:2|max:100|string',
            'body' => 'required|min:10|max:2000|string'
        ]);

        $post = Post::find($id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            
        $post = Post::find($id);
        $mailData = $post->only('title', 'body');
        Mail::to($post->user->email)->send(new DeleteMail($mailData));
        $post->isDeleted == true;
        // $post->delete();
        return redirect('admindashboard');
    }
}
