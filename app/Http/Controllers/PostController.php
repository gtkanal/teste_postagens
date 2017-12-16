<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use Carbon\Carbon;


class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        $user = Auth::user();


        return view('post.index', compact('posts', 'user'));
    }

    public function add()
    {
        return view('post.add');
    }

    public function save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required | max:255',
            'post'=> 'required',
        ]);


        if(!$validator->fails()) {

            $user_id = Auth::user()->id;

            $post = Post::create([
                'user_id' => $user_id,
                'title'   => $request->input('title'),
                'post'    => $request->input('post')
            ]);

        }

        return redirect()->route('post.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        if(!$post){
            return redirect()->route('post.index');
        }

        return view('post.edit', compact('post'));
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

        $update = [
            'title' =>  $request->input('title'),
            'post' =>  $request->input('post')
        ];

        $result = Post::find($id)->update($update);

        return redirect()->route('post.index');
    }

    public function delete($id)
    {
        $post =  Post::find($id);

        if($post){
            $result = $post->delete();
        }

        return redirect()->route('post.index');
    }

    public function search(Request $request)
    {
        $title = $request->input('title');
        $search = TRUE;

        if($title != ''){
            $posts = Post::where('title', 'like', '%' . $title . '%')->paginate(10);
        }else{
            $posts = Post::paginate(10);
        }

        return view('post.index', compact('posts', 'search'));
    }

    public function detail($id, $success = 3, $message = "" )
    {
        $post = Post::find($id);

        $comments = Comment::where('post_id', '=', $id)->orderBy('created_at', 'desc')->get();

        if(!$post){
            return redirect()->route('post.index');
        }

        return view('post.detail', compact('post', 'comments', 'success', 'message'));
    }

}
