<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $order = Order::where('user_id',Auth::user()->id)->where('status',0)->first();
        return view('dashboard.index',[
            'active' => 'home',
            'carts' => OrderDetail::where('user_id',Auth::user()->id)->where('order_id',$order->id),
        ]);
    }
}