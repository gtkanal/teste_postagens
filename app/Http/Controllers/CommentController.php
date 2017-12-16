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
        $success = false;

        $message = "";

        $validator = Validator::make($request->all(), [
            'comment'=> 'required',
        ]);


        if(!$validator->fails()) {

            $user = Auth::user();

            $post_id = $request->input('post_id');

            $post = Post::find($post_id);

            if($post){

                $return = $this->validComment($post->user_id);

                if($return['success']){

                    $comment = Comment::create([
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                        'comment'   => $request->input('comment'),
                    ]);

                    if($comment){

                        $notification = Notification::create([
                            'user_id'    => $post->user_id,
                            'post_id'    => $post->id,
                            'comment_id' => $comment->id,
                        ]);

                    }

                    $success = 1;
                    $message = 'sucesso';


                } else {

                    $success = 0;
                    $message = $return['message'];

                }


            }

            return redirect()->route('post.detail', ['id' => $post->id, 'success' => $success, 'message' => $message ]);
        }

        return redirect()->route('home');

    }


    /* Checa se as condições para o comentário são válidas */
    function validComment($postUserId = null)
    {

        $postUser = User::find($postUserId);

        $loggedUser = Auth::user();

        $lastComment = $loggedUser->comments()->orderBy('created_at', 'desc')->first();


        $valid = true;

        $now = Carbon::now();

        $message = "";

        if($lastComment){
            $minimumDelay = $lastComment->created_at->addSeconds(30);
            if ($now < $minimumDelay){
                $valid = false;
                $message = "Você comentou a menos de 30 segundos!";
            }
        }


        if (!$postUser->isSubscriber() && !$loggedUser->isSubscriber() && !$loggedUser->isFeatured()){
            $valid = false;
            $message = "Você não pode comentar nesta postagem!";
        }

        return ["success" => $valid, "message" => $message];


    }
}
