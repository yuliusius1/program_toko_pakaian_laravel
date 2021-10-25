<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use App\Models\Role;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class AdminController extends Controller
{
    public function index(){
        $order_all = Order::latest()->get();
        $product_all = Product::all(); 
        $product_take = Product::latest()->take(6)->get(); 
        $user_count = User::all();
        return view('admin.index',[
            'active' => 'admin',
            'title' => "Home Page",
            'allOrder' => $order_all->where('status',1),
            'allUser' => $user_count,
            'takeProduct' => $product_take,
            'allProduct' => $product_all,
            'userOrder' => $order_all->where('user_id',Auth::user()->id),
        ]);
    }

    public function productmanagement(){
        if(request('delete')){
            $product_delete = Product::where('id',request('delete'))->first();
            if(empty($product_delete)){
                alert()->error('Product Tidak ada !','Hapus Product Error' );
                return back();
            }
            $product_delete->delete();
            alert()->success($product_delete->name . ' berhasil dihapus dari keranjang','Pesanan Berhasil Dihapus' );
            return  back();
        }
        return view('admin.product_management',[
            'active' => 'admin',
            'products' => Product::orderBy('id','DESC')->paginate(10)->withQueryString(),
            'categories' => Category::all(),
            'sub_categories' => SubCategory::all(),
        ]);
    }

    public function usermanagement(){
        if(request('delete')){
            $user_delete = User::where('id',request('delete'))->first();
            if(empty($user_delete)){
                alert()->error('User Tidak ada !','Hapus User Error' );
                return back();
            }
            $user_delete->delete();
            alert()->success($user_delete->name . ' berhasil dihapus dari keranjang','Pesanan Berhasil Dihapus' );
            return  back();
        }

        return view('admin.user_management',[
            'active' => 'admin',
            'users' => User::latest()->paginate(10)->withQueryString(),
            'roles' => Role::all(),
        ]);
    
    }
    public function subcategorymanagement(){
        if(request('delete')){
            $sub_category_delete = SubCategory::where('id',request('delete'))->first();
            if(empty($sub_category_delete)){
                alert()->error('Sub Category Tidak ada !','Hapus Sub Category Error' );
                return back();
            }
            $sub_category_delete->delete();
            alert()->success($sub_category_delete->sub_category_name . ' berhasil dihapus dari keranjang','Pesanan Berhasil Dihapus' );
            return  back();
        }
        return view('admin.subcategory_management',[
            'active' => 'admin',
            'sub_categories' => SubCategory::orderBy('category_id','DESC')->paginate(10)->withQueryString(),
            'categories' => Category::all(),
        ]);
    }

    public function transactionreport(){
        return view('admin.transaction_report',[
            'active' => 'admin',
            'orders' => Order::orderBy('created_at','DESC')->paginate(10)->withQueryString(),
            'order_details' => OrderDetail::all(),
        ]);
    }

    public function active_product(Request $request){
        $product = Product::where('id',$request->userId)->first();
        if($product->is_active == 1){
            $product->is_active = 0;
        } else {
            $product->is_active = 1;
        }
        $product->update();
        Session::flash('success', 'Data berhasil diubah!');
    }

    public function active_subcategory(Request $request){
        $product = SubCategory::where('id',$request->userId)->first();
        if($product->is_active == 1){
            $product->is_active = 0;
        } else {
            $product->is_active = 1;
        }
        $product->update();
        Session::flash('success', 'Data berhasil diubah!');
    }

    public function active_user(Request $request){
        $user = User::where('id',$request->userId)->first();
        if($user->is_active == 1){
            $user->is_active = 0;
        } else {
            $user->is_active = 1;
        }
        $user->update();
        Session::flash('success', 'Data berhasil diubah!');
    }

    public function checkSlug(Request $request){
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
    
    public function subcat(Request $request){
        $sub_categories = SubCategory::where('category_id',$request->cat_id)->get();
        return Response::json($sub_categories);
    }

    public function addproduct(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => ['required'],
            'sub_category_id' => ['required'],
            'slug' => ['required','unique:products'],
            'size' => ['required'],
            'photo' => 'required|image|file|max:4096',
            'description' => ['required','max:255'],
            'price' => ['required'],
            'stock' => ['required','min:1'],
            'is_active' => ['required'],
        ]);
        if($request->file('photo')){
            $validatedData['photo'] = $request->file('photo')->store('product');
        }

        Product::create($validatedData);
        alert()->success($request->name . ' berhasil ditambahkan','Penambahan Barang Berhasil' );
        return  back();
    }

    public function addsubcategory(Request $request){
        $validatedData = $request->validate([
            'sub_category_name' => 'required|max:255',
            'category_id' => ['required'],
            'slug' => ['required','unique:sub_categories'],
            'is_active' => ['required'],
        ]);

        SubCategory::create($validatedData);
        alert()->success($request->name . ' berhasil ditambahkan','Penambahan Sub Category Berhasil' );
        return  back();
    }

    public function adduser(Request $request){
        $user = User::where('email',$request->email)->first();
        if(!empty($user)){
            alert()->error($request->email . ' Gagal ditambahkan','Penambahan User gagal' );
            return  back();
        }
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'role_id' => ['required'],
            'photo' => ['required'],
            'password' => ['required','min:4'],
            'is_active' => ['required'],
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);
        alert()->success($request->name . ' berhasil ditambahkan','Penambahan User Berhasil' );
        return back();
    }

    public function editsubcategory(Request $request){
        $subcat = SubCategory::where('id',$request->id)->first();
        
        if(empty($subcat)){
            alert()->error($request->sub_category_name . ' gagal ubah','Update Sub Category Gagal' );
            return back();
        }
        
        $validatedData = $request->validate([
            'sub_category_name' => 'required|max:255',
            'category_id' => ['required'],
            'slug' => ['required',Rule::unique('sub_categories')->ignore($subcat)],
            'is_active' => ['required'],
        ]);
        
        $subcat->sub_category_name = $request->sub_category_name;
        $subcat->category_id = $request->category_id;
        $subcat->slug = $request->slug;
        $subcat->is_active = $request->is_active;
        $subcat->update();
        
        alert()->success($request->sub_category_name . ' berhasil diubah','Update Sub Category Berhasil' );
        return  back();
    }

    public function edituser(Request $request){
        $users = User::where('id',$request->id)->first();
        
        if(empty($users)){
            alert()->error($request->name . ' gagal ubah','Update User Gagal' );
            return back();
        }
        
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'role_id' => 'required',
        ]);
        
        $users->name = $request->name;
        $users->role_id = $request->role_id;
        $users->update();
        
        alert()->success($request->name . ' berhasil diubah','Update User Berhasil' );
        return  back();
    }

    public function editproduct(Request $request){
        $products = Product::where('id',$request->id)->first();
        if(empty($products)){
            alert()->error($request->name . ' Tidak ditemukan','Update Product Gagal' );
            return back();
        }
        
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => ['required'],
            'sub_category_id' => ['required'],
            'slug' => ['required',Rule::unique('products')->ignore($products)],
            'size' => ['required'],
            'photo' => 'image|file|max:4096',
            'description' => ['required','max:255'],
            'price' => ['required'],
            'stock' => ['required','min:1'],
            'is_active' => ['required'],
        ]);

        if($request->file('photo')){
            $products->photo = $request->file('photo')->store('product');
        }
        
        $products->name = $request->name;
        $products->category_id = $request->category_id;
        $products->sub_category_id = $request->sub_category_id;
        $products->slug = $request->slug;
        $products->size = $request->size;
        $products->description = $request->description;
        $products->stock = $request->stock;
        $products->price = $request->price;
        $products->is_active = $request->is_active;
        $products->update();
        
        alert()->success($request->name . ' berhasil diubah','Update Product Berhasil' );
        return  back();
    }

    public function reportData(Request $request){
        $path = 'assets/image/logo.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
        
        $datarange = Order::whereBetween('created_at',[$request->startdate.'-01', $request->enddate.'-01'])->get();
        if(empty($datarange)){
            alert()->Error('Data tidak ditemukan','Print Data Gagal' );
            return back();
        }
        
        return view('invoice_page.report',[
            'title' => 'Report Page',
            'orders' => $datarange,
            'data' => $logo,
            'start' => $request->startdate,
            'end' => $request->enddate
        ]);
    }

    public function cetakreport(Request $request){
        $path = 'assets/image/logo.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
        $datarange = Order::whereBetween('created_at',[$request->startdate.'-01', $request->enddate.'-01'])->get();
        if(empty($datarange)){
            alert()->Error('Data tidak ditemukan','Print Data Gagal' );
            return back();
        }
        
        if(request('cetak')){
            $pdf = PDF::loadView('invoice_page.report', [
                'title' => 'Report Page',
                'orders' => $datarange,
                'data' => $logo,
                'start' => $request->startdate,
                'end' => $request->enddate
            ])->setOptions(['defaultFont' => 'sans-serif'])->setPaper('legal','potrait');
            return $pdf->download('LaporanTransaksi_'.$request->startdate.'_'. $request->enddate.'.pdf');
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

    public function confirmation(Request $request){
        if(request('invoice_id')){
            $transaction = order::where('invoice_id', $request->invoice_id)->first();
            if(empty($transaction)){
                alert()->error('Data tidak ditemukan','Konfirmasi Gagal');
                return back();
            }
            $payment = Payment::where('invoice_id',$request->invoice_id)->first();
            $transaction->status = 4;
            $transaction->save();
            $payment->status = 3;
            $payment->save();
            alert()->success('Berhasil di konfirmasi', 'Konfirmasi berhasil');
            return redirect('admin/transaction');
        }
        return view('admin.confirmation',[
            'active' => 'admin',
            'orders' => Order::where('status',2)->orderBy('created_at','DESC')->paginate(10)->withQueryString(),
            'order_details' => OrderDetail::all(),
            'payment' => Payment::all(),
        ]);
    }
}