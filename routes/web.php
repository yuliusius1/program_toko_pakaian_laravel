<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PesanController;
use Symfony\Component\Console\Input\Input;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


        
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::post('/contact', [HomeController::class, 'sendmail']);

Route::get('/forgot', [ForgotPasswordController::class, 'index']);
Route::get('/forgotpass', [ForgotPasswordController::class, 'forgotpassword']);
Route::post('/forgotpass', [ForgotPasswordController::class, 'change_password']);
Route::post('/forgot', [ForgotPasswordController::class, 'forgotpass']);

Route::get('/activation',[RegisterController::class,'activation']);

Route::get('/products',[ProductController::class,'index']);
Route::get('/products/{product:slug}',[ProductController::class,'show'])->middleware('auth');
Route::get('/checkout', [PesanController::class, 'checkout'])->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::post('/order/{id}', [PesanController::class, 'order'])->middleware('auth');
Route::post('/editCart/{id}', [PesanController::class, 'editCart'])->middleware('auth');
Route::get('/confirm', [PesanController::class, 'checkoutConfirm'])->middleware('auth');
Route::get('/invoice',[PesanController::class,'invoice'])->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile', [ProfileController::class, 'store'])->middleware('auth');

Route::get('/changepassword', [ProfileController::class, 'password'])->middleware('auth');
Route::post('/changepassword', [ProfileController::class, 'cpass'])->middleware('auth');

Route::get('/user/history', [UserController::class, 'index'])->middleware('auth');
Route::get('/user/payment', [UserController::class, 'payment'])->middleware('auth');
Route::post('/user/payment', [UserController::class, 'checkpayment'])->middleware('auth');
Route::get('/user/checkpayment', [UserController::class, 'check'])->middleware('auth');

Route::get('/admin', [AdminController::class, 'index'])->middleware('admin');
Route::get('/admin/product', [AdminController::class, 'productmanagement'])->name('admin_product')->middleware('admin');
Route::get('/admin/user', [AdminController::class, 'usermanagement'])->name('admin_user')->middleware('admin');
Route::get('/admin/subcategory', [AdminController::class, 'subcategorymanagement'])->name('admin_subcategory')->middleware('admin');
Route::get('/admin/transaction', [AdminController::class, 'transactionreport'])->name('transaction_admin')->middleware('admin');
Route::get('/admin/cetakreport', [AdminController::class, 'cetakreport'])->name('print_transaction_report')->middleware('admin');
Route::get('/admin/confirmation', [AdminController::class, 'confirmation'])->middleware('admin');

Route::post('/admin/report', [AdminController::class, 'reportData'])->name('transaction_report')->middleware('admin');
Route::post('/admin/editsubcategory', [AdminController::class, 'editsubcategory'])->middleware('admin');
Route::post('/admin/edituser', [AdminController::class, 'edituser'])->middleware('admin');
Route::post('/admin/editproduct', [AdminController::class, 'editproduct'])->middleware('admin');

Route::post('/admin/user', [AdminController::class, 'adduser'])->name('admin_user')->middleware('admin');
Route::post('/admin/subcategory', [AdminController::class, 'addsubcategory'])->middleware('admin');
Route::post('/admin/product', [AdminController::class, 'addproduct'])->middleware('admin');

Route::post('/admin/activesubcategory', [AdminController::class, 'active_subcategory'])->middleware('admin');
Route::post('/admin/activeproduct', [AdminController::class, 'active_product'])->middleware('admin');
Route::post('/admin/activeuser', [AdminController::class, 'active_user'])->middleware('admin');

Route::get('/admin/product/checkSlug', [AdminController::class, 'checkSlug'])->middleware('admin');
Route::get('/admin/product/subcat', [AdminController::class, 'subcat'])->middleware('admin');