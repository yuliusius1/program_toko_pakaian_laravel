<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('user.index',[
            'title' => "History Transaction",
            'active' => "user",
            'userOrder' => Order::where('user_id',Auth::user()->id)->get(),
        ]);
    }

    public function payment(Request $request){
        if(request('id')){
            $user_transaction = Order::where('invoice_id', $request->id)->where('user_id',Auth::user()->id)->where('status',1)->first();
            if(empty($user_transaction)){
                alert()->error('Invoice ID Not Found!',' Payment Failed');
                return redirect('/user/history');
            }
            $user_details = OrderDetail::where('order_id', $user_transaction->id)->get();
            return view('user.payment',[
                'active' => 'user',
                'title' => "User Payment",
                'orders' => $user_transaction,
                'order_details' => $user_details,
            ]);
        } else {
            alert()->error('Invoice ID Not Found!',' Payment Failed');
            return redirect('/user/history');
        }
    }

    public function checkpayment(Request $request){
        $validatedData = $request->validate([
            'payment' => ['required'],
            'from' => ['required'],
            'invoice_id' => ['required'],
        ]);
        
        $user_transaction = Order::where('invoice_id', $request->invoice_id)->where('user_id',Auth::user()->id)->where('status',1)->first();
        if(empty($user_transaction)){
            alert()->error('Invoice ID Not Found!',' Payment Failed');
            return back();
        }
        $user_payment = Payment::where('invoice_id', $request->invoice_id)->first();

        if(empty($user_payment)){
            Payment::create([
                'user_id' => Auth::user()->id,
                'invoice_id' => $request->invoice_id,
                'from' => $request->from,
                'method' => $request->payment,
                'total_price' => $user_transaction->total_harga,
                'status' => 0,
            ]);
            alert()->success('Silahkan melakukan pembayaran pada contact dibawah ini', 'Payment Berhasil dibuat! ');
        }

        $user_details = OrderDetail::where('order_id', $user_transaction->id)->get();
        $payment = Payment::where('invoice_id',$request->invoice_id)->where('user_id', Auth::user()->id)->first();
        
        return view('user.checkpayment',[
            'active' => 'user',
            'title' => "User Payment",
            'orders' => $user_transaction,
            'order_details' => $user_details,
            'payment' => $payment,
        ]);
    }

    public function check(Request $request){
        $user_transaction = Order::where('invoice_id', $request->invoice_id)->where('user_id',Auth::user()->id)->where('status',1)->first();
        if(empty($user_transaction)){
            alert()->error('Invoice ID Not Found!',' Payment Failed');
            return back();
        }
        $user_details = OrderDetail::where('order_id', $user_transaction->id)->get();
        $payment = Payment::where('invoice_id',$request->invoice_id)->where('user_id', Auth::user()->id)->first();
        $user_transaction->status = 2;
        $user_transaction->update();
        $payment->status = 1;
        $payment->update();


        return view('user.checkpayment',[
            'active' => 'user',
            'title' => "User Payment",
            'orders' => $user_transaction,
            'order_details' => $user_details,
            'payment' => $payment,
        ]);
    }
}