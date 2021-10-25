@extends('layouts.app')

@section('content')
<?php 
use App\Models\OrderDetail;
?>
<div class="container">
    <!-- <div class="row justify-content-center">
        <div class="col-md-12">
            <img src="assets/image/logo.png" class="mx-auto d-block" alt="">
        </div>
    </div> -->
    <h4>Welcome Back {{ Auth::user()->name; }},</h4>
    <div class="row my-4">
        <div class="col-md-4 mb-3">
            <div class="card bg-danger">
                <div class="card-body px-5 py-4 text-white">
                    <h5 class="card-title mb-2">Total Products</h5>
                    <hr class="border-light">
                    <span class="card-text h2 mt-4">{{ $allProduct->count() }}+</span> <strong>Products</strong>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-info">
                <div class="card-body px-5 py-4 text-white">
                    <h5 class="card-title mb-2">Total Users Active</h5>
                    <hr class="border-light">
                    <span class="card-text h2 mt-4">{{ $allUser->count() }}+</span> <strong>Users</strong>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-warning">
                <div class="card-body px-5 py-4 text-white">
                    <h5 class="card-title mb-2">Total Success Orders</h5>
                    <hr class="border-light">
                    <span class="card-text h2 mt-4">{{ $allOrder->count() }}+</span> <strong>Orders</strong>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4 px-3 row justify-content-between align-items-center">
        <h4>Latest Products</h4>
        <a href="/products" class="badge badge-pill badge-secondary py-2">See All Product</a>
    </div>
    <div class="row my-4">
        @foreach($takeProduct as $product)
        <div class="col-md-2 mb-3">
            <div class="card h-100">
                <img src="{{url('storage')}}/{{ $product->photo }}" class="card-img-top" alt="...">
                <div class="card-body">

                    <h6 class="card-title">{{ $product->name }}</h6>
                    <small class="card-text">Rp. {{ $product->price }},00</small>
                </div>
                <div class="card-footer border-top-0 bg-white d-flex p-2 justify-content-between">
                    <a href="/products/{{$product->slug}}" class="btn btn-primary "><i class="bi bi-info-circle"></i>
                        Details</a>
                    <form action="/order/{{$product->id}}" method="post">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-cart-plus"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <h4 class="mt-4">Last Order</h4>
    <div class="card my-4">
        <div class="card-header">
            Your Last Order
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice ID</th>
                        <th>Product</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($userOrder as $uo)
                    <tr>
                        <td>{{ $i }} </td>
                        <td><a href=""
                                class="text-decoration-none text-primary font-weight-bold">#{{$uo->invoice_id}}</a></td>
                        <td>
                            <div id="accordion">
                                <button class="btn btn-primary w-100 mb-2" data-toggle="collapse"
                                    data-target="#collapse{{$uo->id}}" aria-expanded="false"
                                    aria-controls="collapseOne">
                                    See List Products
                                </button>
                                <ul class="list-group collapse" id="collapse{{$uo->id}}" aria-labelledby="collapseOne"
                                    data-parent="#accordion">
                                    <?php 
                                        $listOrder = OrderDetail::where('order_id',$uo->id)->get();
                                    ?>
                                    @foreach($listOrder as $lo)
                                    <li class="list-group-item ">
                                        {{ $lo->product->name }} <strong>({{ $lo->quantity }})</strong>
                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                        </td>
                        <td>Rp. {{ number_format($uo->total_harga,0) }}</td>
                        <td>{{ $uo->created_at->format('d F Y') }}</td>
                        <td>
                            @if($uo->status == 0 )
                            <span class="badge badge-pill badge-primary py-2">On Cart</span>
                            @elseif($uo->status == 1)
                            <span class="badge badge-pill badge-warning py-2">Unpaid</span>
                            @elseif($uo->status == 2)
                            <span class="badge badge-pill badge-info py-2">Waiting Confirmation</span>
                            @elseif($uo->status == 3)
                            <span class="badge badge-pill badge-danger py-2">Cancel</span>
                            @else
                            <span class="badge badge-pill badge-pill badge-success py-2">Success</span>
                            @endif
                        </td>
                        <td>
                            <a href="" class="badge badge-pill badge-primary py-2">See Detail</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection