@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-4">
            <h1 class="h3 mb-3 font-weight-normal text-center">Registration Form</h1>
            <form class="form-registration p-0" action="/register" method="post">
                @csrf
                <label for="inputName" class="sr-only">Full Name</label>
                <input type="text" id="inputName" class="form-control rounded-top @error('name') is-invalid @enderror"
                    placeholder="Full Name" autofocus name="name" value="{{old('name')}}">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control  @error('email') is-invalid @enderror"
                    placeholder="Email address" name="email" value="{{old('email')}}">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword"
                    class="form-control rounded-bottom  @error('password') is-invalid @enderror" placeholder="Password"
                    name="password">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <input type="hidden" name="role_id" value="1">
                <input type="hidden" name="photo" value="profile/default.jpg">
                <input type="hidden" name="is_active" value="0">
                <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Register</button>
            </form>
            <small class="d-block text-center mt-3">Already registered? <a href="/login">Login Now</a></small>
        </div>
    </div>
</div>

@endsection