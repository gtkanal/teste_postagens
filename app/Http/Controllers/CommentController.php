<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'comment'=> 'required',
        ]);


        if(!$validator->fails()) {

            $post_id = $request->input('post_id');

            $post = Post::find($post_id);

            $comment = Comment::create([
                'user_id' => $post->user_id,
                'post_id' => $post_id,
                'comment'   => $request->input('comment'),
            ]);

        }

        return redirect()->route('post.detail', ['id' => $post_id]);

    }
}
