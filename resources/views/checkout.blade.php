@extends('layouts.app')

@section('content')

<div class="container">

    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <div class="card">
            @if($orderDetail != null)
            <div class="card-header d-flex justify-content-between">
                <h4>Checkout Menu - #{{ $order->invoice_id }} </h4>
                <a href="/products" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Item</a>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($orderDetail as $pd)
                        <tr>
                            <td>{{ $i}}</td>
                            <td width="100px"><img src="{{url('storage')}}/{{ $pd->product->photo }}"
                                    class="img-thumbnail">
                            </td>
                            <td>{{ $pd->product->name }}</td>
                            <td>{{ $pd->quantity }}</td>
                            <td>Rp. {{ number_format($pd->total_harga,2,",",".") }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                <a role="button" class="badge badge-pill badge-info" data-toggle="modal"
                                    data-target="#ModalLaunch{{$pd->id}}">
                                    Edit
                                </a>
                                <a href="?delete={{$pd->id}}" class="badge badge-pill badge-danger"
                                    onclick="return confirm('Anda Yakin akan menghapus data?');">Hapus</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                        <tr valign="center">
                            <td colspan="4"></td>
                            <td>Rp. {{ number_format($order->total_harga,2,",",".") }}</td>
                            <td colspan="2"><a href="/confirm" class="btn btn-success w-100"
                                    onclick="return confirm('Anda Yakin akan Checkout?');"><i class="bi bi-cart3"></i>
                                    Checkout</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->

<!-- Modal -->
@foreach($orderDetail as $pd)
<div class="modal fade" id="ModalLaunch{{$pd->id}}" tabindex="-1" role="dialog" aria-labelledby="ModalLaunchLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/editCart/{{$pd->id}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLaunchLabel">Edit Product Cart - {{ $pd->product->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group px-3">
                        <label for="exampleInputEmail1">Product Name</label>
                        <input type="email" class="form-control" value="{{$pd->product->name}}" disabled>
                    </div>
                    <div class="form-group px-3">
                        <label>Quantity</label>
                        <div class="input-group w-100">

                            <span class="input-group-btn mr-3">
                                <button type="button" class="quantity-left-minus btn btn-danger" data-type="minus"
                                    data-field="">
                                    <i class="bi bi-dash"></i>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="form-control input-number mr-3"
                                value="{{$pd->quantity}}" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-success btn-number"
                                    data-type="plus" data-field="">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection