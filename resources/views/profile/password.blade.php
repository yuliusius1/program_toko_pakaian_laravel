@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
        </ol>
    </nav>

    <div class="row my-3 align-items-center">

        <div class="col-md-4 ">
            <div class="card border-0 ">
                <div class="card-body text-center">
                    <img src="{{ url('') }}/storage/{{auth()->user()->photo}}" alt=""
                        class="img-fluid rounded-circle mx-auto d-block">
                    <h5>{{ $user->name}}</h5>
                    <p>{{ $user->email}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8 px-3 py-2 border-left">

            <div class="d-flex justify-content-between align-items-center">

                <a href="{{ url()->previous() }}" class="text-decoration-none text-dark h6"><i
                        class="bi bi-arrow-left-circle"></i>
                    Back to main
                    menu</a>
                <a href="/profile" class="btn btn-primary">Edit Profile</a>
            </div>
            <h3 class="mb-4 mt-3">Change Profile Password</h3>
            <form method="post" action="/changepassword">
                @csrf
                <div class="form-group">
                    <label for="name">Old Password</label>
                    <input type="password" class="form-control" id="oldpass" placeholder="Current Password"
                        name="oldpass">
                </div>
                <div class="form-group">
                    <label for="name">New Password</label>
                    <input type="password" class="form-control" id="password1" placeholder="New Password"
                        name="password1">
                </div>
                <div class="form-group">
                    <label for="name">Repeat Password</label>
                    <input type="password" class="form-control" id="password2" placeholder="Repeat New Password"
                        name="password2">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection