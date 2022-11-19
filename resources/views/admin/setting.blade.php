@extends('admin.partials.layout')

@section('title', 'Settings')

@section('style')
    <style>
        .form-control-file {
            border-radius: 0.25rem;
        }

        .form-control-file.is-invalid {
            border-color: #dc3545 !important;
        }
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
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
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card">
                        <!-- form start -->
                        <form action="{{ route('admin.settings') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="site_name">Site Name</label>
                                    <input type="text" id="site_name" name="site_name"
                                           class="form-control @error('site_name') is-invalid @enderror"
                                           value="{{ old('site_name', $setting['site_name']) }}"
                                           placeholder="Enter site name" required>
                                    @error('site_name')
                                        <label for="site_name" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="site_url">Site URL</label>
                                    <input type="url" id="site_url" name="site_url"
                                           class="form-control @error('site_url') is-invalid @enderror"
                                           value="{{ old('site_url', $setting['site_url']) }}"
                                           placeholder="Enter site url" required>
                                    @error('site_url')
                                        <label for="site_url" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="site_logo">Site Logo</label>
                                    @if ($setting['site_logo'] && file_exists(public_path($setting['site_logo'])))
                                        <div class="my-3">
                                            <img src="{{ asset('public/'.$setting['site_logo']) }}" style="max-width: 200px;"
                                                 alt="Site Logo" title="Site Logo">
                                        </div>
                                    @endif
                                    <input type="file" id="site_logo" name="site_logo" accept="image/*"
                                           class="form-control-file border @error('site_logo') is-invalid @enderror">
                                    @error('site_logo')
                                        <label for="site_logo" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="favicon">Favicon</label>
                                    @if ($setting['favicon'] && file_exists(public_path($setting['favicon'])))
                                        <div class="my-3">
                                            <img src="{{ asset('public/'.$setting['favicon']) }}" style="max-width: 50px;"
                                                 alt="Favicon" title="Favicon">
                                        </div>
                                    @endif
                                    <input type="file" id="favicon" name="favicon" accept="image/*"
                                           class="form-control-file border @error('favicon') is-invalid @enderror">
                                    @error('favicon')
                                        <label for="favicon" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="contact_email">Contact Email</label>
                                    <input type="email" id="contact_email" name="contact_email"
                                           class="form-control @error('contact_email') is-invalid @enderror"
                                           value="{{ old('contact_email', $setting['contact_email']) }}"
                                           placeholder="Enter contact email" required>
                                    @error('contact_email')
                                        <label for="contact_email" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="partnership_email">Partnership Email</label>
                                    <input type="email" id="partnership_email" name="partnership_email"
                                           class="form-control @error('partnership_email') is-invalid @enderror"
                                           value="{{ old('partnership_email', $setting['partnership_email']) }}"
                                           placeholder="Enter partnership email" required>
                                    @error('partnership_email')
                                        <label for="partnership_email" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="extension_link">Extension Link</label>
                                    <input type="url" id="extension_link" name="extension_link"
                                           class="form-control @error('extension_link') is-invalid @enderror"
                                           value="{{ old('extension_link', $setting['extension_link']) }}"
                                           placeholder="Enter extension link" required>
                                    @error('extension_link')
                                        <label for="extension_link" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="stripe_link">Stripe Link</label>
                                    <input type="url" id="stripe_link" name="stripe_link"
                                           class="form-control @error('stripe_link') is-invalid @enderror"
                                           value="{{ old('stripe_link', $setting['stripe_link']) }}"
                                           placeholder="Enter stripe payment link" required>
                                    @error('stripe_link')
                                        <label for="stripe_link" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
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
