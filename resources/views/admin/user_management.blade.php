<?php 
use App\Http\Controllers\AdminController;
?>
@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Management</li>
        </ol>
    </nav>
    <button role="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#AddUser"><i
            class="bi bi-plus-circle"></i> Add User</button>
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
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($users as $user)
            <tr>
                <td>{{ $i }} </td>
                <td width="100px"><img src="{{url('storage')}}/{{ $user->photo }}" alt="" class="img-thumbnail"></td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->role->role_name}}</td>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input class="form-check-input um" type="checkbox" @if($user->is_active == 1) checked @endif
                        data-id="{{ $user->id }}">
                    </div>
                </td>
                <td nowrap>
                    <a role="button" class="badge badge-pill badge-info" data-toggle="modal"
                        data-target="#editUser{{$user->id}}">
                        Edit
                    </a>
                    <a href="?delete={{$user->id}}" class="badge badge-pill badge-danger"
                        onclick="return confirm('Anda Yakin akan menghapus data?');">Hapus</a>
                </td>
            </tr>
            <?php $i++; ?>
            @endforeach

        </tbody>


    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $users->links() }}
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="AddUser" tabindex="-1" role="dialog" aria-labelledby="AddUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddUserLabel">Add User </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/user" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">User Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="User Name">
                    </div>
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="photo" value="profile/default.jpg">
                    <input type="hidden" name="is_active" id="is_active" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($users as $user)
<div class="modal fade" id="editUser{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="editUserLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserLabel">Edit User {{ $user->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/edituser" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">User Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="{{ $user->role_id }}">{{ $user->role->role_name }}</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection