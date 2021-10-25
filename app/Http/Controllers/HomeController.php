<?php

namespace App\Http\Controllers;

use Auth;
use App\Mail\SendEmails;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    
    public function index()
    {
        $order_all = Order::latest()->get();
        $product_all = Product::all(); 
        $product_take = Product::latest()->take(6)->get(); 
        $user_count = User::all();
        return view('home',[
            'active' => 'home',
            'title' => "Home Page",
            'allOrder' => $order_all->where('status',1),
            'allUser' => $user_count,
            'takeProduct' => $product_take,
            'allProduct' => $product_all,
            'userOrder' => $order_all->where('user_id',Auth::user()->id),
        ]);
    }

    public function about()
    {
        return view('aboutus',[
            'active' => 'about',
            'title' => "About Us Page",
        ]);
    }

    public function contact()
    {
        return view('contact',[
            'active' => 'contact',
            'title' => "Contact Us Page",
        ]);
    }

    public function sendmail(Request $request)
    {
        $tokens = base64_encode(random_bytes(32));
        $details = [
            'subject' => $request->subject,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'view' => $request->view,
        ];

        Mail::to('672019014@student.uksw.edu')->send(new SendEmails($details));
        alert()->success('Berhasil Terkirim','Email Berhasil dikirim' );
        return back();
    }
}