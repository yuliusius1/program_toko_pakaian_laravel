<?php
use App\Models\SubCategory;
?>
@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card px-3 border-0 shadow">
        <div class="row">

            <img class="col-md-5 img-fluid p-0 rounded" src="{{url('storage')}}/{{ $product->photo }}">
            <div class="col-md-7 card-body pt-4">
                <div class="position-absolute mr-4 mt-4" style="top:1px;right:1px">
                    <a href="/" class="text-reset text-decoration-none text-dark h2"><i class="bi bi-x-circle"></i></a>
                </div>
                <h2 class="mb-3">{{$product->name}}</h2>
                <div class="product-section mt-3 ml-3">
                    <p class="text-muted">
                        {{$product->category->category_name}}/{{$product->subcategory->sub_category_name}}
                    </p>
                    <p class="h4 text-danger mb-3">Rp. {{ number_format($product->price,2,",",".")}}</p>
                </div>
                <div class="w-100 bg-secondary px-4 py-3 text-white mt-4">
                    Garansi 100% Orisinil
                </div>
                <div class="product-section mt-4 ml-3">
                    <h5>Deskripsi Barang</h5>
                    <p>{{$product->description}}</p>

                    <table class="table table-resposive w-50  table-borderless mb-2">
                        <tr>
                            <th>Size</th>
                            <td>{{ $product->size }}</td>
                        </tr>
                        <tr>
                            <th>Stock</th>
                            <td>{{ $product->stock }}</td>
                        </tr>
                    </table>
                </div>
                <div class="product-section ">
                    <form action="/order/{{$product->id}}" method="post">
                        @csrf
                        <h6 class="ml-3">Quantity</h6>
                        <div class="input-group w-50 ml-3">
                            <span class="input-group-btn mr-3">
                                <button type="button" class="quantity-left-minus btn btn-danger" data-type="minus"
                                    data-field="">
                                    <i class="bi bi-dash"></i>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="form-control input-number mr-3"
                                value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-success btn-number"
                                    data-type="plus" data-field="">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </span>
                        </div>

                        <div class="d-flex w-100 mt-3">
                            <button type="submit" class="flex-fill btn btn-primary mr-3">Pesan Sekarang</button>
                            <button type="submit" class="flex-fill btn btn-outline-primary"><i class="bi bi-cart3"></i>
                                Add to Cart</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>

</div>
@endsection