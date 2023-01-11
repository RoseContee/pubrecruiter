@extends('admin.partials.layout')

@php
    $add = empty($resource);
    $title = $add ? 'Add Resource' : 'Edit Resource';
    $url = $add ? route('admin.resource.store') : route('admin.resource.update', $resource['id']);
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
                        <li class="breadcrumb-item active">Resources</li>
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
                        <form action="{{ $url }}" enctype="multipart/form-data" method="POST">
                            @if (!$add)
                                @method('PUT')
                            @endif
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $resource['name']??'') }}"
                                           placeholder="Enter resource name" required>
                                    @error('name')
                                        <label for="name" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input type="url" id="url" name="url"
                                           class="form-control @error('url') is-invalid @enderror"
                                           value="{{ old('url', $resource['url']??'') }}"
                                           placeholder="Enter resource url" required>
                                    @error('url')
                                        <label for="brand_url" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                @if ($resource['logo']??'' && file_exists(public_path($resource['logo'])))
                                    <div class="form-group text-center">
                                        <img src="{{ asset('public/'.$resource['logo']) }}" class="img-fluid"
                                             alt="{{ $resource['name'] }}" style="width: 220px; height: 110px;">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <div class="input-group">
                                        <div class="custom-file @error('logo') is-invalid @enderror">
                                            <input type="file" id="logo" name="logo"
                                                   class="custom-file-input" accept="image/*">
                                            <label class="custom-file-label" for="logo">Choose file</label>
                                        </div>
                                    </div>
                                    @error('logo')
                                        <label for="logo" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                    <label for="logo" class="small font-weight-bold mb-0">Preferred Ratio: 2:1</label>
                                </div>
                                <div class="form-group text-center">
                                    <label>Preview</label>
                                    <div class="row">
                                        <div class="col-12">
                                            <canvas id="preview" width="220" height="110" style="background-color:#c9c9c9;"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <input type="text" id="note" name="note"
                                           class="form-control @error('note') is-invalid @enderror"
                                           value="{{ old('note', $resource['note']??'') }}"
                                           placeholder="Enter note">
                                    @error('note')
                                        <label for="note" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="type">Show For</label>
                                    <select id="type" name="type"
                                            class="form-control @error('type') is-invalid @enderror">
                                        @php $type = old('type', $resource['type'] ?? ''); @endphp
                                        <option value="Brand" @if ($type == 'Brand') selected @endif>Brand</option>
                                        <option value="Creator" @if ($type == 'Creator') selected @endif>Creator</option>
                                    </select>
                                    @error('type')
                                        <label for="type" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ $add ? 'Create' : 'Update' }}</button>
                                <a href="{{ route('admin.resource.index') }}" class="btn btn-danger ml-2">Cancel</a>
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
            $('#logo').on('change', async function(e) {
                let canvas = document.getElementById('preview')
                let ctx = canvas.getContext('2d')
                if (e.target.files.length) {
                    let img = await blobToBase64(e.target.files[0])
                    img = await getImageObject(img)
                    ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0, 220, 110)
                } else {
                    ctx.clearRect(0, 0, 220, 110)
                }
            })

            bsCustomFileInput.init()
        })
    </script>
@endsection
