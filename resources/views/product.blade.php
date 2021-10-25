<?php
use App\Models\SubCategory;
?>
@extends('layouts.app')

@section('content')
<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Product</li>
        </ol>
    </nav>
    <h1 class="text-center mb-4">{{ $title }}</h1>
    <hr class="mb-3">
    <form action="/products">
        @if(request('sc'))
        <input type="hidden" name="category" value="{{request('sc')}}">
        @endif
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search')}}">
            <button class="btn btn-danger ml-3" type="submit">Submit</button>
        </div>
    </form>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div id="accordion">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filter</h5>
                    </div>
                    <div class="card-body p-2">
                        <a class="btn btn-primary w-100 mb-2" href="/products">
                            All
                        </a>
                        @foreach($categories as $category)
                        <button class="btn btn-primary w-100 mb-2" data-toggle="collapse"
                            data-target="#collapse{{$category->slug}}" aria-expanded="true" aria-controls="collapseOne">
                            {{ $category->category_name }}
                        </button>
                        <div id="collapse{{$category->slug}}" class="collapse" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <?php 
                            $subcat = SubCategory::where('category_id','=',$category->id)->get();
                        ?>
                            @foreach($subcat as $sc)
                            <a class="btn btn-outline-primary w-100 mb-2" href="?sc={{ $sc->slug}}">
                                {{ $sc->sub_category_name }}
                            </a>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row justify-content-center">
                @foreach ($products as $product)
                <div class="col-md-4 mb-4 col-sm-6">
                    <a href="/products/{{$product->slug}}" class="text-reset text-decoration-none">
                        <div class="card h-100 shadow-sm">
                            <div class="position-absolute py-1 px-3" style="background-color:rgba(0,0,0,0.5);">
                                <p class="m-0 text-white">{{$product->subcategory->sub_category_name}}</p>
                            </div>
                            <img src="{{url('storage')}}/{{ $product->photo }}" class="card-img-top" alt="...">
                            <div class="card-body mb-0 pb-0">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <strong class="card-text">Rp. {{ number_format($product->price,2,",",".") }}</strong>
                                <small>
                                    <p>Stock : <strong>{{ $product->stock}}</strong></p>
                                </small>
                            </div>
                            <div class="card-footer border-top-0 bg-white d-flex p-2 justify-content-between mt-auto">
                                <a href="/products/{{$product->slug}}" class="btn btn-primary "><i
                                        class="bi bi-info-circle"></i> Details</a>
                                <form action="/order/{{$product->id}}" method="post">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-outline-primary"><i
                                            class="bi bi-cart-plus"></i> Add to
                                        Cart</button>
                                </form>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $products->links() }}
            </div>
        </div>

    </div>

</div>
@endsection