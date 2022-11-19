@extends('admin.partials.layout')

@php
    $add = empty($ad);
    $title = $add ? 'Add AD' : 'Edit AD';
    $url = $add ? route('admin.ads.store') : route('admin.ads.update', $ad['id']);
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
                        <li class="breadcrumb-item active">ADS</li>
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
                        <form action="{{ $url }}" method="POST" enctype="multipart/form-data">
                            @if (!$add)
                                @method('PUT')
                            @endif
                            @csrf
                            <div class="card-body">
                                @if (!$add && $ad['image'] && file_exists(public_path($ad['image'])))
                                    <div class="form-group text-center">
                                        <img src="{{ asset('public/'.$ad['image']) }}" class="img-fluid"
                                             alt="Ads" style="width:300px;height:45px;">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <div class="input-group">
                                        <div class="custom-file @error('image') is-invalid @enderror">
                                            <input type="file" id="image" name="image" class="custom-file-input" accept="image/*"
                                                   @if ($add || !$ad['image'] || !file_exists(public_path($ad['image']))) required @endif>
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                    </div>
                                    @error('image')
                                        <label for="image" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                    <div class="small font-weight-bold">Upload image ratio 60:9</div>
                                </div>
                                <div class="form-group text-center">
                                    <label>Preview as extension</label>
                                    <div class="row">
                                        <div class="col-12">
                                            <canvas id="preview" width="300" height="45" style="background-color:#c9c9c9;"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="link">Link</label>
                                    <textarea id="link" name="link" class="form-control @error('link') is-invalid @enderror"
                                              required>{{ old('link', $ad['link']??'') }}</textarea>
                                    @error('link')
                                        <label for="link" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="active">Active</label>
                                    <select id="active" name="active" class="form-control @error('active') is-invalid @enderror">
                                        @php $active = old('active', $ad['active']??1); @endphp
                                        <option value="1" @if ($active == 1) selected @endif>Enable</option>
                                        <option value="0" @if ($active == 0) selected @endif>Disable</option>
                                    </select>
                                    @error('active')
                                        <label for="active" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ $add ? 'Create' : 'Update' }}</button>
                                <a href="{{ route('admin.ads.index') }}" class="btn btn-danger ml-2">Cancel</a>
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
            bsCustomFileInput.init()

            $('#image').on('change', async function(e) {
                let canvas = document.getElementById('preview')
                let ctx = canvas.getContext('2d')
                if (e.target.files.length) {
                    let img = await blobToBase64(e.target.files[0])
                    img = await getImageObject(img)
                    ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0, 300, 45)
                } else {
                    ctx.clearRect(0, 0, 300, 45)
                }
            })
        })
    </script>
@endsection
