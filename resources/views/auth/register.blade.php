@extends('base')

@section('content')

<div class="container col-md-6 offset-md-3 mt-5">
    <h1 class="text-center"> Registration Page</h1>
    <form action="{{'/register'}}" method="POST">
    {{csrf_field()}}

    <div class="form-group mb-3">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control">
    </div>
    @error('name')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control">
    </div>
    @error('email')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    @error('password')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <div class="form-group mb-3">
        <label for="password_confirmation">Password^</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>
    @error('password')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <div class="d-flex">
        <div class="flex-grow-1">
            <a href="{{'/'}}">Already have an account</a>
        </div>
        <button class="btn btn-primary px-5">Register</button>
    </div>
</form>
</div>
@endsection
