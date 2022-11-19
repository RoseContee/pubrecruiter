@extends('marketplace.auth.layout')

@section('title', 'Reset your password')

@section('content')
    <!--Main Start-->
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-6">
                <form action="{{ url()->current() }}" class="p-0 p-sm-5" method="POST">
                    @csrf
                    <div class="mb-4">
                        <h4>Enter your new password.</h4>
                    </div>
                    <fieldset>
                        @include('marketplace.partials.messages')
                        <div class="form-group">
                            <input type="password" id="password" name="password" required
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter Password">
                            @error('password')
                                <label for="password" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   placeholder="Confirm Password">
                            @error('password_confirmation')
                                <label for="password_confirmation" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-main btn-block">Submit</button>
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
