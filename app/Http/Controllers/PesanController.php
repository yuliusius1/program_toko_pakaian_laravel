<?php

namespace App\Http\Controllers;
use PDF;
use Auth;
use Alert;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index($id){
        $product = Product::firstWhere('id',$id);
        $orderss = Order::where('user_id',Auth::user()->id)->where('status',0)->first();

        return view('order.index',[
            'active' => 'products',
            'title' => 'Pesan barang',
            'product' => $product,
            'carts' => OrderDetail::where('order_id',$order->id)->get(),
            'order' => $orderss,

        ]);
    
    }
    public function order(Request $request,$id){
        $product = Product::firstWhere('id',$id);
        $tanggal = Carbon::now();
        //simpan coba

        $cek_pesanan = Order::where('user_id', Auth::user()->id)->where('status',0)->first();
        $cek_order_detail = [];
        if(!empty($cek_pesanan)){
            $cek_order_detail = OrderDetail::where('product_id',$product->id)->where('order_id',$cek_pesanan->id)->first();
            if($cek_order_detail == true){
                if($request->quantity + $cek_order_detail->quantity  > $product->stock){
                    alert()->error( 'Stock Kurang','Pesanan Gagal');
                    return back();
                }
            } else {
                if($request->quantity > $product->stock){
                    alert()->error( 'Stock Kurang','Pesanan Gagal');
                    return back();
                }
            }
        } 
        if(empty($cek_pesanan)) {
            
            $order = new Order;
            $order->invoice_id = mt_rand(000000,999999);
            $order->user_id = Auth::user()->id;
            $order->date_created = $tanggal;
            $order->status = 0;
            $order->total_harga = $product->price * $request->quantity;
            $order->save();
        }

        //simpan ke database pesanan detail
        $order_baru = Order::where('user_id', Auth::user()->id)->where('status',0)->first();
        $cek_orderDetail = OrderDetail::where('product_id',$product->id)->where('order_id',$order_baru->id)->first();
        

        if(empty($cek_orderDetail)){
            $order_detail = new OrderDetail;
            $order_detail->product_id = $product->id;
            $order_detail->order_id = $order_baru->id;
            $order_detail->quantity = $request->quantity;
            $order_detail->total_harga = $product->price * $request->quantity;
            $order_detail->save();
        } else {
            $cek_orderDetail->quantity += $request->quantity;
            $cek_orderDetail->total_harga += $product->price * $request->quantity;
            $cek_orderDetail->save();
        }

        if(!empty($cek_pesanan)){
            $order_baru->total_harga += $product->price * $request->quantity;
            $order_baru->save();
        }
        
        // alert()->success($product->name . ' berhasil dimasukkan kedalam keranjang','Pesanan Berhasil' )->persistent('Close');
        alert()->success($product->name . ' berhasil dimasukkan kedalam keranjang <br> <a href="/checkout" class="btn btn-primary my-4">Lihat Halaman Keranjang</a>','Pesanan Berhasil' )->html();
        return  back();
    }

    public function checkout(){
        $pesanan = Order::where('user_id', Auth::user()->id)->where('status',0)->first();
        $pesanan_detail = [];
        if(!empty($pesanan)){
            $pesanan_detail = OrderDetail::where('order_id',$pesanan->id)->get();
        }
        
        if(request('delete')){
            $pesanan_delete = OrderDetail::where('order_id',$pesanan->id)->where('id',request('delete'))->first();
            if(empty($pesanan_delete)){
                alert()->error('Pesanan Tidak ada !','Pesanan Error' );
                return  back();
            }
            //Kurangi Jumlah Harga
            $pesanan->total_harga -= $pesanan_delete->total_harga;
            $pesanan->update();
            $pesanan_delete->delete();
            alert()->success($pesanan_delete->product->name . ' berhasil dihapus dari keranjang','Pesanan Berhasil Dihapus' );
            
            return  back();
        }

        return view('checkout',[
            'title' => 'Checkout Page',
            'orderDetail' => $pesanan_detail,
            'order' => $pesanan,
            'active' => 'cart',
        ]);
    }

    public function editCart(Request $request,$id){
        $productCart = OrderDetail::firstWhere('id',$id);
        
        if(empty($productCart)){
            alert()->error('Data Tidak ada','Edit Gagal');
            return back();
        }
        
        if($productCart->product->stock < $request->quantity){
            alert()->error('Stock Kurang','Edit Gagal');
            return back();
        }
        $order = Order::where('id',$productCart->order_id)->first();
        $order->total_harga -= $productCart->total_harga;
        $order->update();
        
        $productCart->quantity = $request->quantity;
        $productCart->total_harga = $request->quantity * $productCart->product->price;
        $productCart->update();
        
        $order->total_harga += $productCart->total_harga;
        $order->update();

        alert()->success($productCart->product->name . ' berhasil diubah dalam keranjang','Pesanan Berhasil Diedit' );
        return back();
    }

    public function checkoutConfirm(){
        $order = Order::where('user_id',Auth::user()->id)->where('status',0)->first();
        if(empty($order)){
            alert()->error('Data Tidak Ditemukan','Checkout Gagal');
            return back();
        }

        $order_detail = OrderDetail::where('order_id',$order->id)->get();
        if($order_detail->count() < 1){
            alert()->error('Cart Kosong','Checkout Gagal');
            return back();
        }

        foreach($order_detail as $od){
            $product = Product::where('id',$od->product_id)->first();
            if(empty($product)){
                alert()->error('Produk tidak ditemukan','Checkout Gagal');
                return back();
            }else if($product->stock < $od->quantity){
                alert()->error('Stock Kurang, silahkan ubah jumlah barang','Checkout Gagal');
                return back();
            }
            $product->stock -= $od->quantity;
            $product->update();
        }

        $order->status = 1;
        $order->update();

        alert()->success('Berhasil Checkout','Pesanan Berhasil di Checkout' );
        return back();
    }

    public function invoice(Request $request){
        $path = 'assets/image/logo.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
        if(request('cetak')){
            $pesanan= Order::where('invoice_id',$request->cetak)->first();
            $pesanan_detail = OrderDetail::where('order_id',$pesanan->id)->get();
            $carbon_date = Carbon::parse($pesanan->created_at);
            $carbon_date->addHours(24);
            $pdf = PDF::loadView('invoice_page.index', [
                'title' => 'Invoice Page',
                'orderDetail' => $pesanan_detail,
                'order' => $pesanan,
                'active' => 'cart',
                'data' => $logo,
                'due' => $carbon_date
            ])->setOptions(['defaultFont' => 'sans-serif'])->setPaper('legal','potrait');
            return $pdf->download('pdf_'.$pesanan->invoice_id.'.pdf');
        }

        if(request('view')){
            $pesanan= Order::where('invoice_id',$request->view)->first();
            $pesanan_detail = OrderDetail::where('order_id',$pesanan->id)->get();
            $carbon_date = Carbon::parse($pesanan->created_at);
            $carbon_date->addHours(24);
            return view('invoice_page.index',[
                'title' => 'Invoice Page',
                'orderDetail' => $pesanan_detail,
                'order' => $pesanan,
                'active' => 'cart',
                'data' => $logo,
                'due' => $carbon_date
            ]);
        }

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

    public function cetakpdf(Request $request){
       
    }
}