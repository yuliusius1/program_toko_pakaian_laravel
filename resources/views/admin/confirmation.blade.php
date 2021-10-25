@extends('layouts.app')

@section('content')
<?php 
use App\Models\OrderDetail; ?>
<div class="container">

    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>

        @if($orders != null)

        <div class="card my-1">
            <div class="card-header">
                Transaction History
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice ID</th>
                            <th>Buyer</th>
                            <th>Product</th>
                            <th>Total Price</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($orders as $o)
                        <tr>
                            <td>{{ $i }} </td>
                            <td><a href=""
                                    class="text-decoration-none text-primary font-weight-bold">#{{$o->invoice_id}}</a>
                            </td>
                            <td>{{ $o->user->name }} </td>
                            <td>
                                <div id="accordion">
                                    <button class="btn btn-primary w-100 mb-2" data-toggle="collapse"
                                        data-target="#collapse{{$o->id}}" aria-expanded="false"
                                        aria-controls="collapseOne">
                                        See List Products
                                    </button>
                                    <ul class="list-group collapse" id="collapse{{$o->id}}"
                                        aria-labelledby="collapseOne" data-parent="#accordion">
                                        <?php 
                                        $listOrder = OrderDetail::where('order_id',$o->id)->get();
                                    ?>
                                        @foreach($listOrder as $lo)
                                        <li class="list-group-item ">
                                            {{ $lo->product->name }} <strong>({{ $lo->quantity }})</strong>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </td>
                            <td>Rp. {{ number_format($o->total_harga,0) }}</td>
                            <?php $payments = $payment->where('invoice_id',$o->invoice_id)->first(); ?>
                            <td>
                                @if($payments->method == 1)
                                Manual payments
                                @elseif($payments->method == 2)
                                OVO
                                @elseif($payments->method == 3)
                                GOPAY
                                @elseif($payments->method == 4)
                                SHOPEEPAY
                                @elseif($payments->method == 5)
                                BCA TRANSFER
                                @elseif($payments->method == 6)
                                BRI TRANSFER
                                @endif
                            </td>
                            <td>{{ $o->created_at->format('d F Y') }}</td>
                            <td>
                                @if($o->status == 0 )
                                <span class="badge badge-pill badge-primary py-2">On Cart</span>
                                @elseif($o->status == 1)
                                <span class="badge badge-pill badge-warning py-2">Unpaid</span>
                                @elseif($o->status == 2)
                                <span class="badge badge-pill badge-info py-2">Waiting Confirmation</span>
                                @elseif($o->status == 3)
                                <span class="badge badge-pill badge-danger py-2">Cancel</span>
                                @else
                                <span class="badge badge-pill badge-pill badge-success py-2">Success</span>
                                @endif
                            </td>
                            <td>
                                <a href="/admin/confirmation?invoice_id={{$o->invoice_id}}" class="btn btn-success "
                                    onclick="return confirm('Anda Yakin akan konfirmasi pembayaran??');">Confirmation</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection