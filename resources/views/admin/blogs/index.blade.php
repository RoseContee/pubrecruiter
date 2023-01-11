@extends('admin.partials.layout')

@section('title', 'Blogs')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blogs</h1>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">Add Blog</a>
                        </div>
                        <div class="card-body">
                            <table id="blogs" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Short Content</th>
                                    <th style="width: 55px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($blogs as $index => $blog)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $blog['title'] }}</td>
                                        <td>
                                            @if ($blog['image'] && file_exists(public_path($blog['image'])))
                                                <img src="{{ asset('public/'.$blog['image']) }}"
                                                     class="img-fluid" alt="Image" style="width:120px;">
                                            @endif
                                        </td>
                                        <td>{{ $blog['short_content'] }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.blogs.show', $blog['id']) }}"
                                                    class="text-primary m-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-ref="{{ $blog['id'] }}"
                                                    class="text-danger m-1 delete-blog">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Short Content</th>
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
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Blog</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this blog?</p>
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
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            let blog = null

            $('#blogs').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [2, 4],
                }, {
                    "searchable": false, "targets": [0, 2, 4],
                }]
            })

            $(document).on('click', '.delete-blog', function(e) {
                e.preventDefault()
                blog = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/blogs') }}/' + blog)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                blog = null
                $('#deleteModal form').attr('action', '')
            })
        })
    </script>
@endsection
