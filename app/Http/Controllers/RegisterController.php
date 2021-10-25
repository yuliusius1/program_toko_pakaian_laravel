<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_Token;
use Illuminate\Http\Request;
use App\Mail\SendVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function index(){
        return view('register.index',[
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => ['required','email:dns', 'unique:users'],
            'password' => ['required','min:4','max:255'],
            'role_id' => ['required'],
            'photo' => ['required'],
            'is_active' => ['required'],
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        
        //Create token
        $token = base64_encode(random_bytes(32));
        
        //Send Email
        $details = [
            'subject' => "Verifikasi Akun",
            'name' => $request->name,
            'email' => $request->email,
            'token' => $token,
            'view' => 'email.verification',
        ];

        Mail::to($request->email)->send(new SendVerification($details));
        User_Token::create([
            'email' => $request->email,
            'token' => $token,
            'type' => 1,
        ]);
        User::create($validatedData);
        // $request->session()->flash('success', 'Registration Successful!! Please Login');
        return redirect('/login')->with('success', 'Registration Successful!! Please Active your account');
    }

    public function activation(Request $request){
        $user_token = User_Token::where('token', $request->token)->where('email',$request->email)->where('type',1)->first();
        if(empty($user_token)){
            alert()->error('Gagal','Email Gagal di aktivasi' );
            return back();
        }

        $user = User::where('email', $request->email)->where('is_active',0)->first();
        if(empty($user)){
            alert()->error('Gagal','Email Gagal di aktivasi' );
            return back();
        }

        $user->is_active = 1;
        $user->update();

        $user_token->delete();

        return redirect('/login')->with('success', 'Activation Successful!! Please Login');
    }
}