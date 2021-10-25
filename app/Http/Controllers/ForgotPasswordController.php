<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_Token;
use Illuminate\Http\Request;
use App\Mail\SendVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function index(){
        return view('forgot.index',[
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    public function forgotpass(Request $request){
        $validatedData = $request->validate([
            'email' => ['required','email:dns'],
        ]);

        $user = User::where('email',$request->email)->first();
        if(empty($user)){
            alert()->error('Email tidak ditemukan','Forgot Password Gagal');
            return back();
        }

        $token = base64_encode(random_bytes(32));
        //Send Email
        $details = [
            'subject' => "Change Password",
            'name' => $user->name,
            'email' => $request->email,
            'token' => $token,
            'view' => 'email.forgot',
        ];

        Mail::to($request->email)->send(new SendVerification($details));
        User_Token::create([
            'email' => $request->email,
            'token' => $token,
            'type' => 2,
        ]);

        return redirect('/login')->with('success', 'The token has been sent to your email');
    }

    public function forgotpassword(Request $request){
        $user_token = User_Token::where('email',$request->email)->where('token',$request->token)->where('type', 2)->first();
        if(empty($user_token)){
            return redirect('/login')->with('loginError', 'User return no data');
        }

        $user = User::where('email', $request->email)->first();
        if(empty($user)){
            alert()->error('Gagal','Email Gagal di aktivasi' );
            return back();
        }

        return view('forgot.change_password',[
            'title' => "Change Password",
            'active' => 'login',
            'email' => $user->email,
            'token' => $user->token,
        ]);

        return redirect('/login')->with('success', 'Activation Successful!! Please Login');
    }   

    public function change_password(Request $request){

        $user_token = User_Token::where('token',$request->token)->where('email',$request->email);
        if(empty($user_token)){
            return redirect('/login')->with('loginError', 'User return no data');
        }
        
        $validatedData = $request->validate([
            'password1' => ['required','min:4'],
            'password2' => ['required','same:password1'],
        ]);

        $user= User::where('email', $request->email)->first();
        if(empty($user)){
            alert()->error('Gagal','Email Gagal di aktivasi' );
            return back();
        }

        $user->password = Hash::make($request->password1);
        $user->update();

        $user_token->delete();

        return redirect('/login')->with('success', 'Reset Password Successful!! Please Login');
    }
}