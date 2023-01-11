@extends('admin.partials.layout')

@php
    $add = empty($blog);
    $title = $add ? 'Add Blog' : 'Edit Blog';
    $url = $add ? route('admin.blogs.store') : route('admin.blogs.update', $blog['id']);
    $old = !empty(old());
@endphp

@section('title', $title)

@section('style')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/summernote/summernote-bs4.min.css') }}">
@endsection

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
                        <li class="breadcrumb-item active">Blogs</li>
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
                                    <label for="title">Title</label>
                                    <input type="text" id="title" name="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title', !$add ? $blog['title'] : '') }}"
                                           placeholder="Enter blog title" required>
                                    @error('title')
                                        <label for="title" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                @php
                                  $image = $blog['image']??'' && file_exists(public_path($blog['image'])) ? asset('public/'.$blog['image']) : '';
                                @endphp
                                <div id="preview" class="form-group text-center" style="{{ !$image ? 'display: none;' : '' }}">
                                    <img src="{{ $image }}" class="img-fluid"
                                         alt="Image" style="width: 220px;">
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <div class="input-group">
                                        <div class="custom-file @error('image') is-invalid @enderror">
                                            <input type="file" id="image" name="image"
                                                   class="custom-file-input" accept="image/*">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                    </div>
                                    @error('image')
                                        <label for="logo" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                    <label for="image" class="small font-weight-bold mb-0">Preferred Ratio: 2:1</label>
                                </div>
                                <div class="form-group">
                                    <label for="short_content">Short Content</label>
                                    <textarea id="short_content" name="short_content"
                                              class="form-control @error('short_content') is-invalid @enderror"
                                              placeholder="Enter blog short content"
                                    >{{ old('short_content', !$add ? $blog['short_content'] : '') }}</textarea>
                                    @error('short_content')
                                        <label for="short_content" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea id="content" name="content"
                                              class="form-control @error('content') is-invalid @enderror"
                                              placeholder="Enter blog content"
                                    >{{ old('content', !$add ? $blog['content'] : '') }}</textarea>
                                    @error('content')
                                        <label for="short_content" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ $add ? 'Create' : 'Update' }}</button>
                                <a href="{{ route('admin.blogs.index') }}"
                                   class="btn btn-danger ml-2">Cancel</a>
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
    <!-- Summernote -->
    <script src="{{ asset('public/assets/vendor/summernote/summernote-bs4.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $('#content').summernote()

            $('#image').on('change', async function(e) {
                let preview = document.getElementById('preview'), img = document.querySelector('#preview img')
                if (e.target.files.length) {
                    img.src = await blobToBase64(e.target.files[0])
                    preview.style.display = 'block'
                } else {
                    const origin_img = '{{ $image }}'
                    img.src = origin_img
                    preview.style.display = origin_img ? 'block' : 'none'
                }
            })

            bsCustomFileInput.init()
        })
    </script>
@endsection
