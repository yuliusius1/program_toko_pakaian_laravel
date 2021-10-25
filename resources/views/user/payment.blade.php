@extends('layouts.app')

@section('content')
<style>
label {
    color: #303135;
}

.form-floating {
    position: relative
}

.form-floating>.form-control,
.form-floating>.form-select {
    height: calc(3.5rem + 2px);
    line-height: 1.25
}

.form-floating>label {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    padding: 1rem .75rem;
    pointer-events: none;
    border: 1px solid transparent;
    transform-origin: 0 0;
    transition: opacity .1s ease-in-out, transform .1s ease-in-out
}

@media (prefers-reduced-motion:reduce) {
    .form-floating>label {
        transition: none
    }
}

.form-floating>.form-control {
    padding: 1rem .75rem
}

.form-floating>.form-control::-moz-placeholder {
    color: transparent
}

.form-floating>.form-control::placeholder {
    color: transparent
}

.form-floating>.form-control:not(:-moz-placeholder-shown) {
    padding-top: 1.625rem;
    padding-bottom: .625rem
}

.form-floating>.form-control:focus,
.form-floating>.form-control:not(:placeholder-shown) {
    padding-top: 1.625rem;
    padding-bottom: .625rem
}

.form-floating>.form-control:-webkit-autofill {
    padding-top: 1.625rem;
    padding-bottom: .625rem
}

.form-floating>.form-select {
    padding-top: 1.625rem;
    padding-bottom: .625rem
}

.form-floating>.form-control:not(:-moz-placeholder-shown)~label {
    opacity: .65;
    transform: scale(.85) translateY(-.5rem) translateX(.15rem)
}

.form-floating>.form-control:focus~label,
.form-floating>.form-control:not(:placeholder-shown)~label,
.form-floating>.form-select~label {
    opacity: .65;
    transform: scale(.85) translateY(-.5rem) translateX(.15rem)
}

.form-floating>.form-control:-webkit-autofill~label {
    opacity: .65;
    transform: scale(.85) translateY(-.5rem) translateX(.15rem)
}
</style>
<div class="container">

    <h2 class="mt-4 text-center text-dark">Make Payment</h2>
    <p class="mb-3 text-center text-muted">Stay Connected with us. Love to hear from you</p>
    <hr>
    <div class="row mt-5">
        <div class="col-md-6 ">

            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <h3>Order Details</h3>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Invoice ID</th>
                                <td>#{{ $orders->invoice_id }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ $orders->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Buyer</th>
                                <td>{{ $orders->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td>Rp. {{ number_format($orders->total_harga,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <th>Product List</th>
                                <td>
                                    @foreach($order_details as $od)
                                    <ul class="list-group">
                                        <li class="list-group-item">{{ $od->product->name }}</li>
                                    </ul>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($orders->status == 0 )
                                    <span class="badge badge-pill badge-primary py-2">On Cart</span>
                                    @elseif($orders->status == 1)
                                    <span class="badge badge-pill badge-warning py-2">Unpaid</span>
                                    @elseif($orders->status == 2)
                                    <span class="badge badge-pill badge-info py-2">Waiting Confirmation</span>
                                    @elseif($orders->status == 3)
                                    <span class="badge badge-pill badge-danger py-2">Cancel</span>
                                    @else
                                    <span class="badge badge-pill badge-pill badge-success py-2">Success</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <form action="/user/payment" method="post">
                @csrf
                <div class="form-floating mb-3">
                    <select class="form-control" id="payment" name="payment">
                        <option value="">Select Payment Method</option>
                        <option value="1">Manual Payment</option>
                        <option value="2">OVO</option>
                        <option value="3">GOPAY</option>
                        <option value="4">SHOPEEPAY</option>
                        <option value="5">BCA Transfer</option>
                        <option value="6">BRI Transfer</option>
                    </select>
                    <label for="payment">Payment Method</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="from" name="from" placeholder="Payment From">
                    <label for="from">From</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="total"
                        value="Rp {{ number_format($orders->total_harga,2,',','.') }}" disabled>
                    <label for="from">Total Price</label>
                </div>
                <input type="hidden" name="invoice_id" id="invoice_id" value="{{ $orders->invoice_id }}">
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary d-block mx-auto py-3 px-5 my-4"><b>Make
                        Payment</b></button>
            </form>
        </div>
    </div>

</div>
@endsection