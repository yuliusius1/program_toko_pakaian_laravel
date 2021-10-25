@extends('layouts.apps')

@section('content')
<style>
label {
    color: #303135;
}

.form-floating {
    position: relative
}

.form-floating>.form-control,
.form-floating>.form-select {
    height: calc(3.5rem + 2px);
    line-height: 1.25
}

.form-floating>label {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    padding: 1rem .75rem;
    pointer-events: none;
    border: 1px solid transparent;
    transform-origin: 0 0;
    transition: opacity .1s ease-in-out, transform .1s ease-in-out
}

@media (prefers-reduced-motion:reduce) {
    .form-floating>label {
        transition: none
    }
}

.form-floating>.form-control {
    padding: 1rem .75rem
}

.form-floating>.form-control::-moz-placeholder {
    color: transparent
}

.form-floating>.form-control::placeholder {
    color: transparent
}

.form-floating>.form-control:not(:-moz-placeholder-shown) {
    padding-top: 1.625rem;
    padding-bottom: .625rem
}

.form-floating>.form-control:focus,
.form-floating>.form-control:not(:placeholder-shown) {
    padding-top: 1.625rem;
    padding-bottom: .625rem
}

.form-floating>.form-control:-webkit-autofill {
    padding-top: 1.625rem;
    padding-bottom: .625rem
}

.form-floating>.form-select {
    padding-top: 1.625rem;
    padding-bottom: .625rem
}

.form-floating>.form-control:not(:-moz-placeholder-shown)~label {
    opacity: .65;
    transform: scale(.85) translateY(-.5rem) translateX(.15rem)
}

.form-floating>.form-control:focus~label,
.form-floating>.form-control:not(:placeholder-shown)~label,
.form-floating>.form-select~label {
    opacity: .65;
    transform: scale(.85) translateY(-.5rem) translateX(.15rem)
}

.form-floating>.form-control:-webkit-autofill~label {
    opacity: .65;
    transform: scale(.85) translateY(-.5rem) translateX(.15rem)
}
</style>
<div class="container">

    <h2 class="mt-4 text-center text-dark">Contact us</h2>
    <p class="mb-3 text-center text-muted">Stay Connected with us. Love to hear from you</p>
    <hr>
    <div class="row mt-5">
        <div class="col-md-6 ">
            <img src="assets/image/logo.png" alt="" class="img-fluid">
        </div>
        <div class="col-md-6">
            <form action="/contact" method="post">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Leave a comment here">
                    <label for="name">Full Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Leave a comment here">
                    <label for="email">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="subject" name="subject"
                        placeholder="Leave a comment here">
                    <label for="subject">Subject</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Leave a comment here" name="comment" id="comment"
                        style="height: 100px"></textarea>
                    <label for="comment">Comments</label>
                </div>
                <input type="hidden" name="view" id="view" value="email.index">
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary d-block mx-auto py-3 px-5 my-4"><b>Send
                        Message</b></button>
            </form>
        </div>
    </div>

</div>
@endsection