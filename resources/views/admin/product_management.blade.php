<?php 
use App\Http\Controllers\AdminController;
use Illuminate\Support\Str;
?>
@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Product Management</li>
        </ol>
    </nav>
    <button role="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProduct"><i
            class="bi bi-plus-circle"></i> Add Product</button>
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show as" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <table class="table text-center table-striped table-responsive productTable" style="color:#858796">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Product Name</th>
                <th>Slug</th>
                <th>Size</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }} </td>
                <td width="100px"><img src="{{url('storage')}}/{{ $product->photo }}" alt="" class="img-thumbnail"></td>
                <td>{{$product->category->category_name}}</td>
                <td>{{$product->subcategory->sub_category_name}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->slug}}</td>
                <td>{{$product->size}}</td>
                <td>{{Str::words($product->description,5)}}</td>
                <td>Rp. {{number_format($product->price,2,',','.')}}</td>
                <td>{{$product->stock}}</td>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input class="form-check-input pm" type="checkbox" @if($product->is_active == 1) checked @endif
                        data-id="{{ $product->id }}">
                    </div>
                </td>
                <td nowrap>
                    <a role="button" class="badge badge-pill badge-info" data-toggle="modal"
                        data-target="#editProduct{{$product->id}}">
                        Edit
                    </a>
                    <a href="?delete={{$product->id}}" class="badge badge-pill badge-danger"
                        onclick="return confirm('Anda Yakin akan menghapus data?');">Hapus</a>
                </td>
            </tr>
            <?php $i++; ?>
            @endforeach

        </tbody>


    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $products->links() }}
    </div>
</div>

<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="addProductLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductLabel">Add Product </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/product" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Product Name">
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select Category Name</option>
                            @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sub_category_id">Sub Category</label>
                        <select name="sub_category_id" id="sub_category_id" class="form-control">
                            <option value="">Select Sub Category Name</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="slug">Product Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug">
                    </div>
                    <div class="form-group">
                        <label for="size">Product Size</label>
                        <input type="text" class="form-control" id="size" name="size" placeholder="Size">
                    </div>
                    <div class="form-group">
                        <label for="description">Product Description</label>
                        <textarea id="description" name="description" rows="3" class="form-control"
                            placeholder="Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Product Price</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" class="form-control" name="price" id="price" placeholder="900000">
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stock">Product stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="" class="img-thumbnail" id="output">
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="photo" name="photo">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="is_active" id="is_active" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>


@foreach($products as $p)
<div class="modal fade" id="editProduct{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="editProductLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductLabel">Edit Product - {{ $p->name }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/editproduct" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $p->name }}">
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="{{ $p->category_id }}">{{ $p->category->category_name }}</option>
                            @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sub_category_id">Sub Category</label>
                        <select name="sub_category_id" id="sub_category_id" class="form-control">
                            <option value="{{ $p->sub_category_id }}">{{ $p->subcategory->sub_category_name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="slug">Product Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ $p->slug }}">
                    </div>
                    <div class="form-group">
                        <label for="size">Product Size</label>
                        <input type="text" class="form-control" id="size" name="size" value="{{ $p->size }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Product Description</label>
                        <textarea id="description" name="description" rows="3"
                            class="form-control">{{ $p->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Product Price</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" class="form-control" name="price" id="price" value="{{ $p->price }}">
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stock">Product stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ $p->stock }}">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="{{url('storage')}}/{{ $p->photo }}" class="img-thumbnail" id="output">
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="photo" name="photo">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="is_active" id="is_active" value="{{ $p->is_active }}">
                    <input type="hidden" name="id" id="id" value="{{ $p->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach




<script>
const name = document.querySelector('#name');
const slug = document.querySelector('#slug');

name.addEventListener('change', function() {
    fetch('/admin/product/checkSlug?name=' + name.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
});
</script>


@endsection