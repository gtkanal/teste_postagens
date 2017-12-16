<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Notification;
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = array();

        $user_id = Auth::user()->id;

        $user_name = Auth::user()->name;

        $notifications = Notification::where('user_id',$user_id)
                            ->where(function ($query){
                                $query->where('first_display_date', null)
                                    ->orWhere('first_display_date', '>', Carbon::now()->subHours(6));
                            })
                            ->get();

        foreach($notifications as $notification){

            $post = $notification->post()->first();

            $comment = $notification->comment()->first();

            $commentUser = $comment->user()->first();

            $messages[] = "Você recebeu um comentário de <strong>".$commentUser->email."</strong> na postatem <b><a href='".route('post.detail', $post->id)."'>".$post->title."</a></b> à ".$comment->hourDiff()." horas";

            if($notification->active == 1){

                $update = [
                    'active' => 0,
                    'first_display_date' => Carbon::now()
                ];

                $result = Notification::find($notification->id)->update($update);
            }

        }


        return view('home',  compact('messages', 'user_name'));
    }
}
