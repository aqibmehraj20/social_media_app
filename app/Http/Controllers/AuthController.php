<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request){
        // validate data
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // login code

        if(\Auth::attempt($request->only('email','password'))){
            return redirect('posts');
        }

        return redirect('login')->withError('Login details are not valid');

    }

    public function register_view()
    {
        return view('auth.register');
    }

    public function register(Request $request){
        // validate
        $request->validate([
            'name'=>'required|unique:users',
            'email' => 'required|unique:users|email',
            'password'=>'required|min:8',
        ]);

        // save in users table

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> \Hash::make($request->password)
        ]);

        // login user here

        if(\Auth::attempt($request->only('email','password'))){
            return redirect('/profile/create');
        }

        return redirect('register')->withError('Error');


    }

     public function logout(){
        \Session::flush();
        \Auth::logout();
        return redirect('');
    }


}
