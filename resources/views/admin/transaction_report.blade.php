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
        <button role="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#printData"><i
                class="bi bi-file-earmark-pdf"></i> Print Data</button>
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
                            <td><a href="/invoice?view={{$o->invoice_id}}"
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
                                <a href="/invoice?view={{$o->invoice_id}}"
                                    class="badge badge-pill badge-primary py-2">See Detail</a>
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
<div class="modal fade" id="printData" tabindex="-1" role="dialog" aria-labelledby="printDataLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printDataLabel">Print Transaction Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/report" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="startdate">Start Date</label>
                        <input type="month" class="form-control" id="startdate" name="startdate">
                    </div>
                    <div class="form-group">
                        <label for="enddate">End Date</label>
                        <input type="month" class="form-control" id="enddate" name="enddate">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Set Time</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection