@extends('marketplace.auth.layout')

@section('title', 'Join As Brand')

@section('content')
    <!--Main Start-->
    <main class="container py-5">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-10 col-lg-6">
                <form action="" class="p-0 p-sm-5"
                      enctype="multipart/form-data" method="POST" onsubmit="submitting()">
                    @csrf
                    <input type="hidden" name="claim" value="{{ old('claim') }}">
                    <div class="mb-4">
                        <h4>Start Your Brand Account</h4>
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
                            <input type="password" id="password" name="password" required
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Password">
                            @error('password')
                                <label for="password" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group claim-profile">
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   placeholder="Confirm Password">
                            @error('password_confirmation')
                                <label for="password_confirmation" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" id="brand_name" name="brand_name" required
                                   class="form-control @error('brand_name') is-invalid @enderror"
                                   value="{{ old('brand_name') }}" placeholder="Brand Name">
                            @error('brand_name')
                                <label for="brand_name" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        @php
                            $claim = stripos($errors->has('domain'), 'We found your domain') !== false;
                        @endphp
                        <div class="form-group">
                            <input type="url" id="brand_url" name="brand_url" required
                                   class="form-control @if($errors->has('brand_url') || $errors->has('domain')) is-invalid @endif"
                                   value="{{ old('brand_url') }}" placeholder="Brand URL">
                            @if($errors->has('brand_url') || $errors->has('domain'))
                                <label for="brand_url" class="text-danger small">
                                    {!! $errors->has('brand_url') ? $errors->first('brand_url') : $errors->first('domain') !!}
                                </label>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="network">Affiliate Network</label>
                            <select id="network" name="network" class="form-control @error('network') is-invalid @enderror">
                                @foreach ($networks as $network)
                                    <option value="{{ $network['id'] }}" @if (old('network') == $network['id']) selected @endif>
                                        {{ $network['name'] }}
                                    </option>
                                @endforeach
                                <option value="" @if (old('email') && !old('network')) selected @endif>Other</option>
                            </select>
                            @error('network')
                                <label for="network" class="text-danger small">{{ $message }}</label>
                            @enderror
                        </div>
                        <div id="other-network" style="display:none;">
                            <div class="form-group">
                                <input type="text" id="network_name" name="network_name"
                                       class="form-control @error('network_name') is-invalid @enderror"
                                       value="{{ old('network_name') }}" placeholder="Network">
                                @error('network_name')
                                    <label for="network_name" class="text-danger small">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="url" id="network_link" name="network_link"
                                       class="form-control @error('network_link') is-invalid @enderror"
                                       value="{{ old('network_link') }}" placeholder="Network Link">
                                @error('network_link')
                                    <label for="network_link" class="text-danger small">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div id="preview-container" class="form-group text-center" style="display: none;">
                            <label>Preview</label>
                            <div class="row">
                                <div class="col-12">
                                    <canvas id="preview" style="width:220px;height:110px;background-color:#c9c9c9;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-label text-center">
                            <label for="logo" class="d-block mb-0">
                                <span class="btn btn-success small px-5 py-3">SELECT LOGO</span>
                                <input type="file" name="logo" id="logo" accept="image/*">
                            </label>
                            @error('logo')
                                <label for="logo" class="text-danger small mb-0">{{ $message }}</label>
                            @enderror
                            <label for="logo" class="mt-2">Logo (Preferred Ratio: 2:1)</label>
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
            @if (old('claim') && !$errors->has('brand_name') && !$errors->has('brand_url') && !$errors->has('domain'))
                $('.form-group:not(.claim-profile)').hide()
            @else
                $('[name=claim]').val('')
            @endif

            $(document).on('click', '#claim-profile', function() {
                $('.form-group:not(.claim-profile)').hide()
                $('[name=claim]').val('1')
            })

            $('#network').on('change', function() {
                toggleOtherNetwork()
            })

            $('#logo').on('change', async function(e) {
                let canvas = document.getElementById('preview')
                let ctx = canvas.getContext('2d')
                if (e.target.files.length) {
                    let img = await blobToBase64(e.target.files[0])
                    img = await getImageObject(img)
                    ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0, 220, 110)
                    $('#preview-container').show()
                } else {
                    $('#preview-container').hide()
                    ctx.clearRect(0, 0, 220, 110)
                }
            })

            toggleOtherNetwork()
        })

        function toggleOtherNetwork() {
            if ($('#network').val()) {
                $('#other-network').hide()
                $('#network_name').removeAttr('required')
                $('#network_link').removeAttr('required')
            } else {
                $('#other-network').show()
                $('#network_name').attr('required', 'required')
                $('#network_link').attr('required', 'required')
            }
        }

        function submitting() {
            $('button[type="submit"]').attr('disabled', 'disabled')
            $(".preloader-outer").show()
            $(".loader").show()
        }
    </script>
@endpush
