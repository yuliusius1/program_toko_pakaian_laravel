@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
        </ol>
    </nav>
    <div class="row my-3 align-items-center">
        <div class="col-md-4 ">
            <div class="card border-0 ">
                <div class="card-body text-center">
                    <img src="{{ url('') }}/storage/{{auth()->user()->photo}}" alt=""
                        class="img-fluid rounded-circle mx-auto d-block p-4">
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
                <a href="/changepassword" class="btn btn-primary"> Change Password</a>
            </div>
            <h3 class="mb-4 mt-3">Edit Profile</h3>
            <form method="post" action="/profile" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" disabled
                        value="{{$user->email}}">

                </div>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Full Name" name="name"
                        value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="{{ url('') }}/storage/{{auth()->user()->photo}}" class="img-thumbnail"
                                id="output">
                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection