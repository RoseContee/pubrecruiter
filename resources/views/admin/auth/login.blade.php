@extends('admin.auth.layout')

@section('title', 'Login')

@section('content')
    <p class="login-box-msg">Sign In</p>

    <form action="{{ route('admin.login') }}" method="post">
        @csrf
        @include('admin.partials.messages')
        <label class="input-group">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required
                   value="{{ old('email') }}" placeholder="Email">
            <span class="input-group-append">
                <span class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </span>
            </span>
        </label>
        @error('email')
            <div class="small text-danger">{{ $message }}</div>
        @enderror
        <label class="input-group mt-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required
                   placeholder="Password">
            <span class="input-group-append">
                <span class="input-group-text">
                    <span class="fas fa-lock"></span>
                </span>
            </span>
        </label>
        @error('password')
            <div class="small text-danger">{{ $message }}</div>
        @enderror
        <div class="row mt-3">
            <div class="col-12 text-center">
                <a href="{{ route('admin.forgot-password') }}">Forgot Password?</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember" value="1">
                    <label for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
@endsection
