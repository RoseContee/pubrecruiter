@extends('marketplace.auth.layout')

@section('title', 'Join As Creator')

@section('content')
    <!--Main Start-->
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-6">
                <form action="" class="p-0 p-sm-5" method="POST" onsubmit="submitting()">
                    @csrf
                    <input type="hidden" name="claim" value="{{ old('claim') }}">
                    <div class="mb-4">
                        <h4>Start Your Creator Account</h4>
                    </div>
                    <fieldset>
                        @include('marketplace.partials.messages')
                        <div class="form-group claim-profile">
                            <input type="email" id="email" name="email" required
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="Email">
                            @error('email')
                                <label for="email" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group claim-profile">
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Password" required>
                            @error('password')
                                <label for="password" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group claim-profile">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   placeholder="Confirm Password" required>
                            @error('password_confirmation')
                                <label for="password_confirmation" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" id="website_name" name="website_name" required
                                   class="form-control @error('website_name') is-invalid @enderror"
                                   value="{{ old('website_name') }}" placeholder="Name of Website/Creator">
                            @error('website_name')
                                <label for="website_name" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        @php
                            $claim = stripos($errors->has('domain'), 'We found your domain') !== false;
                        @endphp
                        <div class="form-group">
                            <input type="url" id="website" name="website" required
                                   class="form-control @if ($errors->has('website') || $errors->has('domain')) is-invalid @endif"
                                   value="{{ old('website') }}" placeholder="Website or Social Media URL">
                            @if ($errors->has('website') || $errors->has('domain'))
                                <label for="website" class="text-danger small">
                                    {!! $errors->has('website') ? $errors->first('website') : $errors->first('domain') !!}
                                </label>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="d-block">What are you interested in?</label>
                            <div class="custom-control custom-checkbox mb-1">
                                <input type="checkbox" id="offers" name="offers" class="custom-control-input"
                                       value="1" @if(old('offers')) checked @endif>
                                <span class="custom-control-label"></span>
                                <label for="offers" class="cursor-pointer mb-0">Affiliate Offers</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="posts" name="posts" class="custom-control-input"
                                       value="1" @if(old('posts')) checked @endif>
                                <span class="custom-control-label"></span>
                                <label for="posts" class="cursor-pointer mb-0">Sponsored Posts</label>
                            </div>
                        </div>
                        <div class="form-group claim-profile">
                            <label class="d-block">Do you want to display your profile for brands to see?</label>
                            <div class="d-flex">
                                <div class="custom-control custom-radio w-100">
                                    <input id="show-in-brands" type="radio" name="active" class="custom-control-input"
                                           value="1" @if(old('active', 1) == 1) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="show-in-brands" class="cursor-pointer mb-0">Yes</label>
                                </div>
                                <div class="custom-control custom-radio w-100">
                                    <input id="show-not-brands" type="radio" name="active" class="custom-control-input"
                                           value="0" @if(old('active', 1) == 0) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="show-not-brands" class="cursor-pointer mb-0">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group claim-profile">
                            <button type="submit" class="btn btn-main btn-block">Start</button>
                        </div>
                        <div class="form-group text-center claim-profile">
                            <a href="{{ route('login') }}" class="text-info">
                                Already have an account? <span class="text-danger">Login</span>
                            </a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection

@push('script')
    <script type="text/javascript">
        $(function() {
            @if (old('claim') && !$errors->has('website_name') && !$errors->has('website') && !$errors->has('domain'))
                $('.form-group:not(.claim-profile)').hide()
            @else
                $('[name=claim]').val('')
            @endif

            $(document).on('click', '#claim-profile', function() {
                $('.form-group:not(.claim-profile)').hide()
                $('[name=claim]').val('1')
            })
        })

        function submitting() {
            $('button[type="submit"]').attr('disabled', 'disabled')
            $(".preloader-outer").show()
            $(".loader").show()
        }
    </script>
@endpush
