<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CrownShop') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<?php  
    use App\Models\Order;
    use App\Models\OrderDetail; 
?>

<body>
    @include('sweet::alert')
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{  url('assets') }}/image/logo.png" width="100" alt="">
                </a>

                <button class=" navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ ($active === 'home') ? 'active' : '' }}" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($active === 'about') ? 'active' : '' }}" href="/about">About
                                Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($active === 'product') ? 'active' : '' }}"
                                href="/products">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($active === 'contact') ? 'active' : '' }}" href="/contact">Contact
                                Us</a>
                        </li>
                        @auth
                        @if(Auth::user()->role_id == 2)
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown"
                                class="nav-link dropdown-toggle {{ ($active === 'admin') ? 'active' : '' }}" href="#"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Admin Menu
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item border-bottom py-2" href="/admin/confirmation">
                                        <i class="bi bi-file-earmark-check-fill"></i>
                                        Transaction Confirmation
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-bottom py-2" href="/admin/transaction">
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                        Transaction Reports
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-bottom py-2" href="/admin/subcategory">
                                        <i class="bi bi-collection-fill"></i>
                                        Sub Category Management
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-bottom py-2" href="/admin/product">
                                        <i class="bi bi-server"></i>
                                        Product Management
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-bottom py-2" href="/admin/user">
                                        <i class="bi bi-person-circle"></i>
                                        User Management
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @elseif(Auth::user()->role_id == 1)
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown"
                                class="nav-link dropdown-toggle {{ ($active === 'admin') ? 'active' : '' }}" href="#"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                User Menu
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item border-bottom py-2" href="/user/history">
                                        <i class="bi bi-file-earmark-medical-fill"></i>
                                        Transaction History
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @endauth
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @auth
                        <?php
                            $pesanan_utama = Order::where('user_id',Auth::user()->id)->where('status',0)->first();
                            $pesanan_detail = [];
                            if(!empty($pesanan_utama)){
                                $pesanan_detail =  OrderDetail::where('order_id',$pesanan_utama->id)->get();
                            }
                        ?>
                        <li class="nav-item dropdown">
                            @if($pesanan_detail != null)
                            <a id="navbarDropdown"
                                class="nav-link dropdown-toggle {{ ($active === 'cart') ? 'active' : '' }}" href="#"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-cart3"></i>
                                Cart <span class="badge badge-danger "> {{ $pesanan_detail->count() }} </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right p-0 shadow" style="min-width:350px;"
                                aria-labelledby="navbarDropdown">
                                <li class="border-bottom bg-dark rounded-top dropdown-item">
                                    <p class="text-light mb-0 py-2"><i class="bi bi-cart3"></i> Shopping
                                        Cart ({{ $pesanan_detail->count() }})
                                    </p>
                                </li>
                                @foreach($pesanan_detail as $productCart)
                                <li class="border-bottom">
                                    <div class="dropdown-item d-flex justify-content-between align-items-center py-3">
                                        <a class="detail-item text-decoration-none text-dark"
                                            href="{{  url('products') }}/{{$productCart->product->slug}}">
                                            <strong>
                                                {{ $productCart->product->name }} - {{ $productCart->quantity }}
                                            </strong>
                                            <small>
                                                <p class="mb-0 text-muted">
                                                    Rp. {{ number_format($productCart->total_harga,2,",",".")}}</p>
                                            </small>
                                        </a>
                                        <a href="/checkout?delete={{$productCart->id}}" class="btn btn-danger btn-sm"><i
                                                class="bi bi-x"></i></a>
                                    </div>
                                </li>
                                @endforeach
                                <li class="">
                                    <a class="dropdown-item mb-0 text-center bg-dark py-2 rounded-bottom"
                                        href="/checkout">
                                        <strong class="text-light">
                                            Rp. {{ number_format($pesanan_utama->total_harga,2,",",".")}} - View Cart
                                        </strong>
                                    </a>
                                </li>
                            </ul>
                            @else
                            <a id="navbarDropdown"
                                class="nav-link dropdown-toggle {{ ($active === 'cart') ? 'active' : '' }}" href="#"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-cart3"></i>
                                Cart <span class="badge badge-danger "> 0 </span>
                            </a>
                            @endif
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown"
                                class="nav-link dropdown-toggle {{ ($active === 'user') ? 'active' : '' }}" href="#"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <li class="px-4 text-center border-bottom">
                                    <img src="{{ url('') }}/storage/{{auth()->user()->photo}}" alt=""
                                        class="img-fluid rounded-circle p-3">
                                    <h5>{{ auth()->user()->name}}</h5>
                                    <p class="mb-0">{{ auth()->user()->email}}</p>
                                    <p><small class="text-muted">{{auth()->user()->role->role_name}}</small></p>
                                </li>
                                <li>
                                    <a class="dropdown-item border-bottom py-2" href="/profile">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-bottom py-2" href="/changepassword">
                                        <i class="bi bi-key"></i>
                                        Change Password
                                    </a>
                                </li>
                                <li>
                                    <form action="/logout" method="post" class="">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2"><i
                                                class="bi bi-box-arrow-right"></i>
                                            Logout</button>
                                    </form>
                                </li>
                                <form id="logout-form" action="" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link {{ ($active === 'login') ? 'active' : '' }}" href="/login"><i
                                    class="bi bi-box-arrow-in-right"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($active === 'register') ? 'active' : '' }}" href="/register"><i
                                    class="bi bi-person-check"></i> Register</a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @include('layouts.footer')

</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
</script>
<script>
$('#category_id').on('change', function(e) {
    console.log(e);
    var cat_id = e.target.value;
    $.get('/admin/product/subcat?cat_id=' + cat_id, function(data) {
        $('#sub_category_id').empty();
        $.each(data, function(index, subcatObj) {
            $('#sub_category_id').append('<option value="' + subcatObj.id + '">' + subcatObj
                .sub_category_name + '</option');
        });
    });
});

$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
    $('#output').attr('src', window.URL.createObjectURL(this.files[0]));
});

$('.as').delay(3000).fadeTo(1000, 0).slideUp(1000, function() {
    $(this).remove();
});

$('.scm').on('click', function() {
    const userId = $(this).data('id');
    var token = $('input[name="csrfToken"]').attr('value')
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: " {{url('')}}/admin/activesubcategory ",
        type: 'post',
        data: {
            userId: userId
        },
        success: function() {
            window.location.href = "{{ route('admin_subcategory')}}";
            // document.location.href = "/admin/product";
        }
    });
});

$('.pm').on('click', function() {
    const userId = $(this).data('id');
    var token = $('input[name="csrfToken"]').attr('value')
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: " {{url('')}}/admin/activeproduct ",
        type: 'post',
        data: {
            userId: userId
        },
        success: function() {
            window.location.href = "{{ route('admin_product')}}";
            // document.location.href = "/admin/product";
        }
    });
});

$('.um').on('click', function() {
    const userId = $(this).data('id');
    var token = $('input[name="csrfToken"]').attr('value')
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: " {{url('')}}/admin/activeuser ",
        type: 'post',
        data: {
            userId: userId
        },
        success: function() {
            window.location.href = "{{ route('admin_user')}}";
        }
    });
});

$(function() {
    // ------------------------------------------------------- //
    // Multi Level dropdowns
    // ------------------------------------------------------ //
    $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
        event.preventDefault();
        event.stopPropagation();

        $(this).siblings().toggleClass("show");


        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-submenu .show').removeClass("show");
        });

    });
});



$(document).ready(function() {

    var quantitiy = 0;
    $('.quantity-right-plus').click(function(e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());

        // If is not undefined

        $('#quantity').val(quantity + 1);


        // Increment

    });

    $('.quantity-left-minus').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());

        // If is not undefined

        // Increment
        if (quantity > 0) {
            $('#quantity').val(quantity - 1);
        }
    });

});
</script>

</html>