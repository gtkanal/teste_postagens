<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use Carbon\Carbon;
use App\User;
use App\Models\Notification;
use App\Models\Comment;
use App\Models\Post;

class ApiController extends Controller
{
    public function getComments($postId)
    {

        try{
            $post = Post::find($postId);

            if(!$post){
                return $this->response("Postagem não encontrada",404);
            }else{

                $comments = Comment::where('post_id', '=', $post->id)->orderBy('created_at', 'desc')->paginate(10);
                foreach($comments as $comment){

                    $return[] = [
                        'id_usuario'    => $comment->user->id,
                        'id_comentario' => $comment->id,
                        'login'         => $comment->user->email,
                        'assinante'     => $comment->user->isSubscriber() ? true : false,
                        'data_hora'     => $comment->formattedDate(),
                        'comentario'    => $comment->comment,
                    ];

                }

                return $this->response($return,200);

            }

        }catch(\Exception $e){

            return $this->reportError($e);

        }

    }

    public function getNotifications($userId){


        try{

            $user = User::find($userId);

            if(!$user){
                return $this->response("Usuário não encontrado",404);
            }else{

                $notifications = Notification::where('user_id',$user->id)
                                    ->where(function ($query){
                                        $query->where('first_display_date', null)
                                            ->orWhere('first_display_date', '>', Carbon::now()->subHours(6));
                                    })->paginate(10);

                foreach($notifications as $notification){

                    $post = $notification->post()->first();

                    $comment = $notification->comment()->first();

                    $commentUser = $comment->user()->first();

                    $return[] = [
                        'id_notificacao'        => $notification->id,
                        'id_postagem'           => $post->id,
                        'id_comentario'         => $comment->id,
                        'id_comentario_usuario' => $comment->id,
                        'id_comentario_usuario' => $comment->id,
                        'data_hora_comentario'  => $comment->formattedDate(),
                        'mensagem_notificacao'  => "Recebeu um comentário de ".$commentUser->email." na postatem ".$post->title." à ".$comment->hourDiff()." horas",
                    ];


                    if($notification->active == 1){

                        $update = [
                            'active' => 0,
                            'first_display_date' => Carbon::now()
                        ];

                        $result = Notification::find($notification->id)->update($update);
                    }

                }

                return $this->response($return,200);
            }
        }catch(\Exception $e){
            return $this->reportError($e);
        }
    }

    public function setComment(Request $request)
    {
        try{

            $user = Auth::user();

            if(!$user) {

                $error = array(
                    'message' => "Usuário não encontrado"
                );

                return $this->response($error, 404);

            } else {

                if ($request->input('post_id') && $request->input('comment')) {

                    $post_id = $request->input('post_id');

                    $post = Post::find($post_id);

                    if(!$post){

                        $error = array(
                            'message' => "Postagem não encontrada"
                        );

                        return $this->response($error, 404);

                    } else {

                        $postUser = User::find($post->id);

                        $lastComment = $user->comments()->orderBy('created_at', 'desc')->first();

                        $now = Carbon::now();



                        if ($lastComment) {

                            $minimumDelay = $lastComment->created_at->addSeconds(30);

                            if ($now < $minimumDelay) {

                                $error = array(
                                    'message' => "Este usuário fez um comentário a menos de 30 segundos"
                                );

                                return $this->response($error, 400);

                            }
                        }


                        if (!$postUser->isSubscriber() && !$user->isSubscriber() && !$user->isFeatured()) {

                            $error = array(
                                'message' => "O escritor da postagem não é assinante e o usuário não é assinante nem comprou destaque "
                            );

                            return $this->response($error, 400);

                        }



                        $comment = Comment::create([

                            'user_id' => $user->id,
                            'post_id' => $post_id,
                            'comment' => $request->input('comment'),

                        ]);

                        if ($comment) {

                            $notification = Notification::create([

                                'user_id' => $post->user_id,
                                'post_id' => $post_id,
                                'comment_id' => $comment->id,

                            ]);

                        }

                        return $this->response($comment,200);

                    }

                }else{

                    $error = array('message'=>'Parâmetros incorretos.');

                    return $this->response($error,400);

                }
            }

        }catch(\Exception $e){

            return $this->reportError($e);

        }

    }


    public function reportError($e)
    {
        if (env('APP_DEBUG')) {
            $error = array('message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile());
        } else {
            $error = array('message' => 'Ocorreu um erro ao processar a requisição.');
        }
    }

    public function response($data,$code){
        switch ($code) {
            case 404:
                return \Response::json($data, 404);
                break;
            case 401:
                return \Response::json("Unauthorized", 401);
                break;
            case 500:
                return \Response::json($data, 500);
                break;
            case 200:
                return \Response::json($data, 200);
            case 415:
                return \Response::json($data, 415);
            case 400:
                return \Response::json($data, 400);

        }
    }
}
