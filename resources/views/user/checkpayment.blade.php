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
    <hr>
    <div class="row mt-5">
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <h3>Payment Details</h3>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Invoice ID</th>
                                <td>#{{ $orders->invoice_id }}</td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td>
                                    @if($payment->method == 1)
                                    Manual Payment
                                    @elseif($payment->method == 2)
                                    OVO
                                    @elseif($payment->method == 3)
                                    GOPAY
                                    @elseif($payment->method == 4)
                                    SHOPEEPAY
                                    @elseif($payment->method == 5)
                                    BCA TRANSFER
                                    @elseif($payment->method == 6)
                                    BRI TRANSFER
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>From</th>
                                <td>{{ $payment->from }}</td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td>Rp. {{ number_format($payment->total_price,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($payment->status == 0 )
                                    <span class="badge badge-pill badge-pill badge-warning py-2">Waiting Payment</span>
                                    @elseif($payment->status == 1 )
                                    <span class="badge badge-pill badge-pill badge-primary py-2">Waiting
                                        Confirmation</span>
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
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <h3>Payment To</h3>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Method</th>
                                <td>
                                    @if($payment->method == 1)
                                    Manual Payment
                                    @elseif($payment->method == 2)
                                    OVO
                                    @elseif($payment->method == 3)
                                    GOPAY
                                    @elseif($payment->method == 4)
                                    SHOPEEPAY
                                    @elseif($payment->method == 5)
                                    BCA TRANSFER
                                    @elseif($payment->method == 6)
                                    BRI TRANSFER
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Number</th>
                                <td>+62 895 0178 4227</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>Yulius</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="/user/checkpayment?invoice_id={{$payment->invoice_id}}"
                class="btn btn-block btn-primary py-3 mt-3">Check
                Transaction</a>
        </div>
    </div>

</div>
@endsection