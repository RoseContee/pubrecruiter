@extends('admin.partials.layout')

@section('title', 'Approval Users')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Approval</li>
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
                        <div class="card-body">
                            <table id="approvals" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Paid At</th>
                                    <th>Expired At</th>
                                    <th style="width: 45px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $user['name'] }}</td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>{{ $user['paid_at'] ?? '' }}</td>
                                        <td>{{ $user['expires'] ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('admin.approval.edit', $user['id']) }}" title="Approval"
                                               class="btn btn-success px-2 py-1 m-1">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            {{--<button data-ref="{{ $user['id'] }}" title="Block"
                                               class="btn btn-danger px-2 py-1 m-1 Block-user">
                                                <i class="fas fa-ban"></i>
                                            </button>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Paid At</th>
                                    <th>Expired At</th>
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

    {{--<!-- Delete Modal -->
    <div id="deleteModal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Block User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to block this user?</p>
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
    </div>--}}
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            let user = null

            $('#approvals').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [5],
                }, {
                    "searchable": false, "targets": [0, 5],
                }]
            })

            /*$(document).on('click', '.approval-user', function(e) {
                e.preventDefault()
                user = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/approval') }}/' + user)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                user = null
                $('#deleteModal form').attr('action', '')
            })*/
        })
    </script>
@endsection
