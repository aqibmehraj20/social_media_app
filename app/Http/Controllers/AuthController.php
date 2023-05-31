<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // validate data
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $loginField = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // login code

        if (\Auth::attempt([$loginField => $request->input('login'), 'password' => $request->input('password')])) {
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


        return redirect()->back()->withInput();


    }

     public function logout(){
        \Session::flush();
        \Auth::logout();
        return redirect('');
    }

    public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function handleGoogleCallback()
{
    try {
        $user = Socialite::driver('google')->user();
    } catch (\Exception $e) {
        // Handle exception if the user authentication fails
        return redirect()->route('login')->with('error', 'Google authentication failed');
    }

    // Logic to authenticate/register the user and redirect as needed
    // You can check if the user exists in your application's database using their email or create a new user account

    // Example: Authenticate the user and redirect to the home page
    auth()->login($user);
    return redirect()->route('home');
}

}
