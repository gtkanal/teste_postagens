<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use Carbon\Carbon;
use App\User;

class UserController extends Controller
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
        $users = User::paginate(10);


        return view('user.index', compact('users'));
    }

    public function add()
    {
        return view('user.add');
    }

    public function save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        if(!$validator->fails()) {

            $user = User::create([
                'name'       => $request->input('name'),
                'email'      => $request->input('email'),
                'password'   => bcrypt($request->input('password')),
                'subscriber' => $request->input('subscriber') == 1 ? 1 : 0,
                'featured'   => $request->input('featured') == 1 ? 1 : 0,
                'role'       => $request->input('role') == 1 ? 1 : 0,
            ]);

        }

        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if(!$user){
            return redirect()->route('user.index');
        }

        return view('user.edit', compact('user'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        if(!$validator->fails()) {

            $update = [
                'subscriber' => $request->input('subscriber') == 1 ? 1 : 0,
                'featured' => $request->input('featured') == 1 ? 1 : 0,
                'role' => $request->input('role') == 1 ? 1 : 0,
            ];

            if($request->input('password')){
                $update['password'] = bcrypt($request->input('password'));
            }

            $result = User::find($id)->update($update);
        }


        return redirect()->route('user.index');
    }

    public function delete($id)
    {
        $user = User::find($id);

        if($user){
            $result = $user->delete();
        }

        return redirect()->route('user.index');
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
}
