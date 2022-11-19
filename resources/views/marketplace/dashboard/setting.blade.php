@extends('marketplace.dashboard.layout')

@section('title', 'Account Setting')

@section('content')
    <!--Main Start-->
    <main id="main-container">
        <div class="row">
            <div class="col-md-12 col-lg-10 col-xl-8">

                @include('marketplace.partials.messages')

                <div id="setting-page" class="card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-md-3 pr-0">
                                <div class="nav flex-column nav-tabs h-100" role="tablist" aria-orientation="vertical">
                                    <a href="#tabs-profile"
                                       class="nav-link @if (old('type', 'profile') == 'profile') active @endif"
                                       data-toggle="pill" role="tab">Profile</a>
                                    <a href="#tabs-password"
                                       class="nav-link @if (old('type') == 'password') active @endif"
                                       data-toggle="pill" role="tab">Password</a>
                                    <a href="#tabs-email"
                                       class="nav-link @if (old('type') == 'email') active @endif"
                                       data-toggle="pill" role="tab">Email</a>
                                </div>
                            </div>
                            <div class="col-md-9 pl-0">
                                <div class="tab-content bg-white">
                                    <div id="tabs-profile" role="tabpanel"
                                         @class(['tab-pane', 'fade', 'active show' => old('type', 'profile') == 'profile'])>
                                        <form action="{{ route('setting') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="type" value="profile">
                                            <fieldset>
                                                <h6 class="tab-title">My {{ auth()->user()->type }} Setting</h6>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" id="active" name="active" class="custom-control-input"
                                                               value="1" @if(old('active', $contact['active'])) checked @endif>
                                                        <span class="custom-control-label"></span>
                                                        <label for="active" class="cursor-pointer mb-0">
                                                            Show in Marketplace
                                                        </label>
                                                    </div>
                                                </div>
                                                <hr>
                                                @if (auth()->user()->type == 'Creator' && count($metrics))
                                                    <h6 class="tab-title">Business Metrics</h6>
                                                    @foreach ($metrics as $metric)
                                                        <div class="form-group row">
                                                            <div class="col-12 col-sm-5 col-md-4 col-lg-4 pl-0">
                                                                <label for="metric{{ $metric['id'] }}" class="form-control border-0 mb-0">
                                                                    {{ $metric['type'] }}
                                                                </label>
                                                            </div>
                                                            <div class="col-12 col-sm-7 col-md-8 col-lg-8 pr-0">
                                                                <input type="text" id="metric{{ $metric['id'] }}" name="metric{{ $metric['id'] }}"
                                                                       value="{{ old('metric'.$metric['id'], $user_metrics[$metric['id']] ?? '') }}"
                                                                       class="form-control @error('metric'.$metric['id']) is-invalid @enderror"
                                                                       placeholder="Enter {{ $metric['type'] }}">
                                                                <label for="metric{{ $metric['id'] }}" class="d-block small mb-0" style="line-height:1.5;">
                                                                    ex: 10000, 10K, 7.1M
                                                                </label>
                                                                @error('metric'.$metric['id'])
                                                                    <label for="metric{{ $metric['id'] }}" class="d-block small text-danger mb-0" style="line-height:1.3;">
                                                                        {{ $message }}
                                                                    </label>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <hr>
                                                @endif
                                                <div class="form-group text-right">
                                                    <button type="submit" class="btn btn-main">Update</button>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div id="tabs-password" role="tabpanel"
                                         @class(['tab-pane', 'fade', 'active show' => old('type') == 'password'])>
                                        <h6 class="tab-title">Change Your Password</h6>
                                        <form action="{{ route('setting') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="type" value="password">
                                            <fieldset>
                                                <div class="form-group">
                                                    <input type="password" id="current_password" name="current_password"
                                                           class="form-control @error('current_password') is-invalid @enderror"
                                                           placeholder="Current Password" required>
                                                    @error('current_password')
                                                        <label for="current_password" class="text-danger small">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" id="new_password" name="password"
                                                           class="form-control @if(old('type', 'password') == 'password' && $errors->has('password')) is-invalid @endif"
                                                           placeholder="New Password" required>
                                                    @if(old('type', 'password') == 'password' && $errors->has('password'))
                                                        <label for="new_password" class="text-danger small">{{ $errors->first('password') }}</label>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                                           placeholder="Confirm Password" required>
                                                    @error('password_confirmation')
                                                        <label for="password_confirmation" class="text-danger small">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="form-group text-right">
                                                    <button type="submit" class="btn btn-main">Update</button>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div id="tabs-email" role="tabpanel"
                                         @class(['tab-pane', 'fade', 'active show' => old('type') == 'email'])>
                                        <h6 class="tab-title">
                                            Change Your Account Email
                                        </h6>
                                        <form action="{{ route('setting') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="type" value="email">
                                            <fieldset>
                                                <div class="form-group">
                                                    <div class="form-control">{{ auth()->user()->email }}</div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" id="email" name="email"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           placeholder="New Email" value="{{ old('email') }}" required>
                                                    @error('email')
                                                        <label for="email" class="text-danger small">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" id="password" name="password"
                                                           class="form-control @if(old('type') == 'email' && $errors->has('password')) is-invalid @endif"
                                                           placeholder="Password" required>
                                                    @if(old('type') == 'email' && $errors->has('password'))
                                                        <label for="password" class="text-danger small">{{ $errors->first('password') }}</label>
                                                    @endif
                                                </div>
                                                <div class="form-group text-right">
                                                    <button type="submit" class="btn btn-main">Update</button>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection
