@extends('admin.partials.layout')

@section('title', 'Users')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a>
                        </div>
                        <div class="card-body">
                            <table id="users" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th style="width: 35px;">Type</th>
                                    <th style="width: 60px;">Expires</th>
                                    <th class="py-0">Referral<br>Code</th>
                                    <th style="width: 100px;">Ad Supported</th>
                                    <th style="width: 45px;">Active</th>
                                    <th style="width: 55px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user['id'] }}</td>
                                        <td>{{ $user['name'] }}</td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>{{ $user['type'] }}</td>
                                        <td>{{ $user['expires'] ?? '' }}</td>
                                        <td>{{ $user['info']['referral']['code'] ?? '' }}</td>
                                        <td>
                                            @if ($user['ad_supported'])
                                                <span class="badge badge-success">Enabled</span>
                                            @else
                                                <span class="badge badge-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user['active'])
                                                <span class="badge badge-success">Enabled</span>
                                            @else
                                                <span class="badge badge-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.users.show', $user['id']) }}"
                                               class="text-primary m-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-ref="{{ $user['id'] }}"
                                                    class="text-danger m-1 delete-user">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Expires</th>
                                    <th class="py-0">Referral<br>Code</th>
                                    <th>Ad Supported</th>
                                    <th>Active</th>
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
                        <h4 class="modal-title">Delete User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this user?</p>
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
            let user = null

            $('#users').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [8],
                }, {
                    "searchable": false, "targets": [8],
                }]
            })

            $(document).on('click', '.delete-user', function(e) {
                e.preventDefault()
                user = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/users') }}/' + user)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                user = null
                $('#deleteModal form').attr('action', '')
            })
        })
    </script>
@endsection
