<?php 
use App\Http\Controllers\AdminController;
?>
@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sub Category Management</li>
        </ol>
    </nav>
    <button role="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSubCategory"><i
            class="bi bi-plus-circle"></i> Add SubCategory</button>
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show as" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <table class="table text-center table-striped productTable" style="color:#858796">
        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($sub_categories as $sc)
            <tr>
                <td>{{ $i }} </td>
                <td>{{$sc->category->category_name}}</td>
                <td>{{$sc->sub_category_name}}</td>
                <td>{{$sc->slug}}</td>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input class="form-check-input scm" type="checkbox" @if($sc->is_active == 1) checked @endif
                        data-id="{{ $sc->id }}">
                    </div>
                </td>
                <td nowrap>
                    <a role="button" class="badge badge-pill badge-info" data-toggle="modal"
                        data-target="#editSubCategory{{$sc->id}}">
                        Edit
                    </a>
                    <a href="?delete={{$sc->id}}" class="badge badge-pill badge-danger"
                        onclick="return confirm('Anda Yakin akan menghapus data?');">Hapus</a>
                </td>
            </tr>
            <?php $i++; ?>
            @endforeach

        </tbody>


    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $sub_categories->links() }}
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addSubCategory" tabindex="-1" role="dialog" aria-labelledby="addSubCategoryLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubCategoryLabel">Add Sub Category </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/subcategory" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Sub Category Name</label>
                        <input type="text" class="form-control" id="sub_category_name" name="sub_category_name"
                            placeholder="Sub Category Name">
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
                        <label for="slug">Sub Category Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug">
                    </div>
                    <input type="hidden" name="is_active" id="is_active" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Sub Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($sub_categories as $sc)
<div class="modal fade" id="editSubCategory{{$sc->id}}" tabindex="-1" role="dialog"
    aria-labelledby="editSubCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubCategoryLabel">Edit Sub Category {{ $sc->sub_category_name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/editsubcategory" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Sub Category Name</label>
                        <input type="text" class="form-control" id="sub_category_name" name="sub_category_name"
                            value="{{ $sc->sub_category_name }}">
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="{{ $sc->category_id }}">{{ $sc->category->category_name }}</option>
                            @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="slug">Sub Category Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ $sc->slug }}">
                    </div>
                    <input type="hidden" name="is_active" id="is_active" value="{{ $sc->is_active }}">
                    <input type="hidden" name="id" id="id" value="{{ $sc->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Sub Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection