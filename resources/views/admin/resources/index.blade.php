@extends('admin.partials.layout')

@section('title', 'Resources')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Resources</h1>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.resource.create') }}" class="btn btn-primary">Add Resource</a>
                        </div>
                        <div class="card-body">
                            <table id="resources" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Logo</th>
                                    <th>Note</th>
                                    <th>Show For</th>
                                    <th style="width: 55px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($resources as $index => $resource)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $resource['name'] }}</td>
                                        <td>
                                            <a href="{{ $resource['url'] }}" target="_blank">
                                                {{ $resource['url'] }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($resource['logo'] && file_exists(public_path($resource['logo'])))
                                                <img src="{{ asset('public/'.$resource['logo']) }}"
                                                     class="img-fluid" alt="{{ $resource['name'] }}" style="width:120px;">
                                            @endif
                                        </td>
                                        <td>{{ $resource['note'] }}</td>
                                        <td>{{ $resource['type'] }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.resource.show', $resource['id']) }}"
                                                    class="text-primary m-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-ref="{{ $resource['id'] }}"
                                                    class="text-danger m-1 delete-resource">
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
                                    <th>URL</th>
                                    <th>Logo</th>
                                    <th>Note</th>
                                    <th>Show For</th>
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
                        <h4 class="modal-title">Delete Resource</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this resource?</p>
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
            let resource = null

            $('#resources').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [3, 6],
                }, {
                    "searchable": false, "targets": [0, 3, 6],
                }]
            })

            $(document).on('click', '.delete-resource', function(e) {
                e.preventDefault()
                resource = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/resource') }}/' + resource)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                resource = null
                $('#deleteModal form').attr('action', '')
            })
        })
    </script>
@endsection
