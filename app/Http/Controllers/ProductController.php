<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Auth;

class ProductController extends Controller
{
    public function index(){
        
        $title = '';
        if(request('sc')){
            $sc = SubCategory::firstWhere('slug', request('sc'));
            $title = ' in '. $sc->sub_category_name;
        }

        return view('product',[
            'title' => 'Halaman Produk' . $title,
            'categories' => Category::all(),
            "products" => Product::where('is_active',1)->latest()->filter(request(['search','sc']))->paginate(21)->withQueryString(),
            'active' => 'product',
        ]);
    }

    public function show(Product $product){
        return view('products',[
            "title" => "Product",
            'product' => $product,
            'categories' => Category::all(),
            'active' => 'product',
        ]);

    }
}