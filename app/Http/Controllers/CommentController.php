<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request)
    {
        $success= false;

        $validator = Validator::make($request->all(), [
            'comment'=> 'required',
        ]);


        if(!$validator->fails()) {

            $user = Auth::user();

            $post_id = $request->input('post_id');

            $post = Post::find($post_id);

            $success = $this->validComment($post->user_id);

            if($success){

                $comment = Comment::create([
                    'user_id' => $user->id,
                    'post_id' => $post_id,
                    'comment'   => $request->input('comment'),
                ]);

                if($comment){

                    $notification = Notification::create([
                        'user_id'    => $post->user_id,
                        'post_id'    => $post_id,
                        'comment_id' => $comment->id,
                    ]);

                }


            }


        }
        $success = $success ? 1 : 0;
        return redirect()->route('post.detail', ['id' => $post_id, 'success' => $success]);

    }


    /* Checa se as condições para o comentário são válidas */
    function validComment($postUserId = null)
    {

        $postUser = User::find($postUserId);

        $loggedUser = Auth::user();

        $lastComment = $loggedUser->comments()->orderBy('created_at', 'desc')->first();


        $valid = true;

        $now = Carbon::now();

        if($lastComment){
            $minimumDelay = $lastComment->created_at->addSeconds(30);
            $valid = $valid && ($now > $minimumDelay);
        }


        $valid = $valid && ($postUser->isSubscriber() || $loggedUser->isSubscriber() || $loggedUser->isFeatured());

        return $valid;


    }
}
