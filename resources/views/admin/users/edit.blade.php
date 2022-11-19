@extends('admin.partials.layout')

@php
    $add = empty($user);
    $title = $add ? 'Add User' : 'Edit User';
    $url = $add ? route('admin.users.store') : route('admin.users.update', $user['id']);
@endphp

@section('title', $title)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @include('admin.partials.messages')
            <div class="row">
                <!-- left column -->
                <div class="col-12">
                    <!-- general form elements -->
                    <div class="card">
                        <!-- form start -->
                        <form action="{{ $url }}" method="POST">
                            @if (!$add)
                                @method('PUT')
                            @endif
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Brand/Creator Name</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $user['name']??'') }}" placeholder="Enter name" required>
                                    @error('name')
                                        <label for="name" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', $user['email']??'') }}" placeholder="Enter email" required>
                                    @error('email')
                                        <label for="email" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select id="type" name="type" class="form-control @error('type') is-invalid @enderror">
                                        @php $type = old('type', $user['type']??'Brand'); @endphp
                                        <option value="Brand" @if ($type == 'Brand') selected @endif>Brand</option>
                                        <option value="Creator" @if ($type == 'Creator') selected @endif>Creator</option>
                                    </select>
                                    @error('type')
                                        <label for="type" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="expires">Expires</label>
                                    <input type="text" id="expires" name="expires" class="form-control @error('expires') is-invalid @enderror"
                                           value="{{ old('expires', $user['expires']??'') }}" placeholder="Enter expires"
                                           data-target="#timepicker" data-toggle="datetimepicker">
                                    @error('expires')
                                        <label for="expires" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="ad_supported">Ad Supported</label>
                                    <select id="ad_supported" name="ad_supported" class="form-control @error('ad_supported') is-invalid @enderror">
                                        @php $ad_supported = old('ad_supported', $user['ad_supported']??1); @endphp
                                        <option value="1" @if ($ad_supported == 1) selected @endif>Enable</option>
                                        <option value="0" @if ($ad_supported == 0) selected @endif>Disable</option>
                                    </select>
                                    @error('ad_supported')
                                        <label for="active" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="active">Active</label>
                                    <select id="active" name="active" class="form-control @error('active') is-invalid @enderror">
                                        @php $active = old('active', $user['active']??1); @endphp
                                        <option value="1" @if ($active == 1) selected @endif>Enable</option>
                                        <option value="0" @if ($active == 0) selected @endif>Disable</option>
                                    </select>
                                    @error('active')
                                        <label for="active" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Password" @if ($add) required @endif>
                                    @error('password')
                                        <label for="password" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           class="form-control" placeholder="Confirm Password" @if ($add) required @endif>
                                </div>
                                <div class="form-group">
                                    <label for="referral_code">Referral Code</label>
                                    <select id="referral_code" name="referral_code" class="form-control @error('referral_code') is-invalid @enderror">
                                        <option value="">Select referral code</option>
                                        @php $referral_code = old('referral_code', $user['info']['referral_code_id']??null); @endphp
                                        @foreach ($referrals as $referral)
                                            <option value="{{ $referral['id'] }}" @if ($referral_code == $referral['id']) selected @endif>
                                                {{ $referral['code'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('referral_code')
                                        <label for="referral_code" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ $add ? 'Create' : 'Update' }}</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-danger ml-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $('#expires').datetimepicker({
                format: 'YYYY-MM-DD',
            })
        })
    </script>
@endsection
