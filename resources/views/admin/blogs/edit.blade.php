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
                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <input type="text" id="tags" name="tags"
                                           class="form-control @error('tags') is-invalid @enderror"
                                           value="{{ trim(old('tags', $blog['tags']??''), ',') }}"
                                           placeholder="Enter tags">
                                    @error('tags')
                                        <label for="tags" class="small text-danger font-weight-normal mb-0">
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
                <!-- /.col -->
                @if (!$add)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Comments</h5>
                            </div>
                            <div class="card-body">
                                <table id="comments" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 20px;">No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                        <th style="width: 55px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($blog['comments'] as $index => $comment)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $comment['name'] }}</td>
                                            <td>{{ $comment['email'] }}</td>
                                            <td>{{ $comment['comment'] }}</td>
                                            <td>{{ $comment['created_at'] }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" data-ref="{{ $comment['id'] }}"
                                                   class="text-danger m-1 delete-comment">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                @endif
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @if (!$add)
        <!-- Delete Modal -->
        <div id="deleteModal" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Comment</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure to remove this comment?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endif
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

            @if (!$add)
                let comment = null
    
                $('#comments').DataTable({
                    "responsive": true,
                    "lengthMenu": [100, 250, 500],
                    "autoWidth": false,
                    "columnDefs": [{
                        "sortable": false, "targets": [3, 5],
                    }, {
                        "searchable": false, "targets": [0, 5],
                    }]
                })
    
                $(document).on('click', '.delete-comment', function(e) {
                    e.preventDefault()
                    comment = $(this).data('ref')
                    $('#deleteModal').modal('show').find('form').attr('action', '{{ url("admin/blogs/{$blog['id']}/comments") }}/' + comment)
                })
    
                $('#deleteModal').on('hidden.bs.modal', function () {
                    comment = null
                    $('#deleteModal form').attr('action', '')
                })
            @endif
        })
    </script>
@endsection
