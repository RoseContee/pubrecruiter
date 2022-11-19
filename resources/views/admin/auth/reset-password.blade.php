@extends('admin.auth.layout')

@section('title', 'Reset your password')

@section('content')
    <p class="login-box-msg font-weight-bold">Enter your new password.</p>

    <form action="{{ url()->current() }}" method="post">
        @csrf
        @include('admin.partials.messages')
        <label class="input-group">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required
                   placeholder="Enter Password">
            <span class="input-group-append">
                <span class="input-group-text">
                    <span class="fas fa-lock"></span>
                </span>
            </span>
        </label>
        @error('password')
            <div class="small text-danger">{{ $message }}</div>
        @enderror
        <label class="input-group mt-3">
            <input type="password" name="password_confirmation" class="form-control" required
                   placeholder="Confirm Password">
            <span class="input-group-append">
                <span class="input-group-text">
                    <span class="fas fa-lock"></span>
                </span>
            </span>
        </label>
        <div class="row mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
@endsection
