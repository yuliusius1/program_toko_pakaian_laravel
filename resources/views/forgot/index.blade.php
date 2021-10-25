@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-4">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if(session()->has('forgotError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('forgotError') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <h1 class="h3 mb-3 font-weight-normal text-center">Forgot Password</h1>
            <form class="form-signin p-0" action="/forgot" method="post">
                @csrf
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Email address" name="email" value="{{old('email')}}" required autofocus>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Send me an email!</button>
            </form>
            <small class="d-block text-center mt-3">Not registered? <a href="/register">Register Now</a></small>
        </div>
    </div>
</div>
@endsection