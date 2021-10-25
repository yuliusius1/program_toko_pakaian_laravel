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
            @if(session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('loginError') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <h1 class="h3 mb-3 font-weight-normal text-center">Reset Password</h1>
            <form class="form-signin p-0" action="/forgotpass" method="post">
                @csrf
                <label for="inputNewPassword" class="sr-only">New Password</label>
                <input type="password" id="inputNewPassword"
                    class="form-control @error('password1') is-invalid @enderror" placeholder="New Password"
                    name="password1" required autofocus>
                @error('password1')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <label for="inputRepeatPassword" class="sr-only">New Password</label>
                <input type="password" id="inputRepeatPassword"
                    class="form-control @error('password2') is-invalid @enderror" placeholder="Repeat Password"
                    name="password2" required autofocus>
                @error('password2')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <input type="hidden" name="token" id="token" value="{{ $token }}">
                <input type="hidden" name="email" id="email" value="{{ $email }}">
                <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Reset Password</button>
            </form>

        </div>
    </div>
</div>

@endsection