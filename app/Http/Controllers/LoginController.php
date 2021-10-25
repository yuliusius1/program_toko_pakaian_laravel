<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login',
            'active' =>'login',
        ]);
    }

    public function authenticate(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if(empty($user)){
            return back()->with('loginError','Login failed!'); 
        }

        if($user->is_active != 1){
            return back()->with('loginError','Login failed! your account not actived'); 
        }

        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
                $request->session()->regenerate();
                if(Auth::user()->role_id == 1){
                    return redirect('/');
                } else if(Auth::user()->role_id == 2){
                    return redirect('/admin');
                }
        }

        return back()->with('loginError','Login failed!'); 
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}