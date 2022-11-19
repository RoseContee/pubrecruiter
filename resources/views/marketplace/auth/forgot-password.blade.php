@extends('marketplace.auth.layout')

@section('title', 'Forgot password')

@section('content')
    <!--Main Start-->
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-6">
                <form action="{{ route('forgot-password') }}" class="p-0 p-sm-5" method="POST">
                    @csrf
                    <div class="mb-4">
                        <h4>Reset your password</h4>
                        <p>Enter your account email address so we can reset your password.</p>
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
                            <button type="submit" class="btn btn-main btn-block">Next</button>
                        </div>
                        <div class="form-group text-center">
                            <a href="{{ route('login') }}" class="text-info">Back to login</a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection
