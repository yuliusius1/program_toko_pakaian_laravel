<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index(){
        $user = User::where('id',Auth::user()->id)->first();

        return view('profile.index',[
            'user' => $user,
            'active' => 'user',
            'title' => 'Edit User',
        ]);
    }
    public function password(){
        $user = User::where('id',Auth::user()->id)->first();

        return view('profile.password',[
            'user' => $user,
            'active' => 'user',
            'title' => 'Edit Password',
        ]);
    }

    public function cpass(Request $request){
        $user = User::where('id',Auth::user()->id)->first();
        if (!(Hash::check($request->get('oldpass'), Auth::user()->password))) {
            // The passwords matches
            alert()->error('Your current password does not matches with the password you provided. Please try again.','Change Password Failed')->persistent('close');
            return back();  
        }

        if(strcmp($request->get('oldpass'), $request->get('password1')) == 0){
            //Current password and new password are same
            alert()->error('New Password cannot be same as your current password. Please choose a different password..','Change Password Failed')->persistent('close');
            return back(); 
        }

        if (strcmp($request->get('password1'), $request->get('password2')) != 0) {
            // The passwords matches
            alert()->error('Repeat Password must be same with New Password','Change Password Failed')->persistent('close');
            return back(); 
        }

        $validatedData = $request->validate([
            'oldpass' => 'required',
            'password1' => 'required|string|min:3',
            'password2' => 'required|same:password1',
        ]);
        
        $user->password = Hash::make($request->password1);
        $user->update();
        alert()->success('Password berhasil diganti','Change Password Success');
        return back();
    }

    public function store(Request $request){
        $user = User::where('id', Auth::user()->id)->first();
        $validatedData = $request->validate([
            'name' => 'required|min:6|max:255',
            'image' => 'image|file|max:2048',
        ]);
        
        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('profile');
            $imgs = $user->photo;
            $user->photo = $request->file('image')->store('profile');
            if(strcmp($imgs,"profile/default.jpg") != 0){
                unlink("storage/".$imgs);
            }
        }
        
        $user->name = $request->name;
        $user->update();
        

        alert()->success('Data Berhasil diganti','Change Data Success');
        return back();
        
    }
}