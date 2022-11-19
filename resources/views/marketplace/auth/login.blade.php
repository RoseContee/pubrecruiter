@extends('marketplace.auth.layout')

@section('title', 'Login')

@section('content')
    <!--Main Start-->
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-6">
                <form action="{{ route('login') }}" class="p-0 p-sm-5" method="POST">
                    @csrf
                    <div class="mb-4">
                        <h4>Welcome Back</h4>
                    </div>
                    <fieldset>
                        @include('marketplace.partials.messages')
                        <div class="form-group">
                            <input type="email" id="email" name="email" required
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="Email">
                            @error('email')
                                <label for="email" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" name="password" required
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Password">
                            @error('password')
                                <label for="password" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-main btn-block">Login</button>
                        </div>
                        <div class="form-group text-center">
                            <a href="{{ route('forgot-password') }}" class="text-info">Forgot password?</a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection
