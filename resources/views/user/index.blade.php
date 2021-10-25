@extends('layouts.app')

@section('content')
<?php 
use App\Models\OrderDetail; ?>
<div class="container">

    <h2 class="text-center">Transaction History</h2>
    <hr>
    <div class="card my-4">
        <div class="card-header">
            Your Last Order
        </div>
        @if($userOrder != null)
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
                                class="text-decoration-none text-primary font-weight-bold">#{{$uo->invoice_id}}</a>
                        </td>
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
                            <a href="/user/payment?id={{$uo->invoice_id}}"
                                class="badge badge-pill badge-warning py-2">Make Payment</a>
                            <a href="/invoice?view={{$uo->invoice_id}}" class="badge badge-pill badge-primary py-2">See
                                Detail</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection