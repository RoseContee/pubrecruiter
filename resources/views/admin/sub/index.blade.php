@extends('admin.partials.layout')

@section('title', 'SUB Records')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>SUB Records</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">SUB Record</li>
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
                            <table id="records" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>Affiliate Name</th>
                                    <th>Brand Sign Up</th>
                                    <th>Date</th>
                                    <th style="width: 45px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($records as $index => $record)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $record['user']['name'] }}</td>
                                        <td>
                                            {{ $record['contact']['user']['name'] }}
                                        </td>
                                        <td>
                                            {{ date('n/j/Y', strtotime($record['created_at'])) }}
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" data-ref="{{ $record['id'] }}"
                                                    class="text-danger m-1 delete-record">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Affiliate Name</th>
                                    <th>Brand Sign Up</th>
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
                        <h4 class="modal-title">Delete SUB Record</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this record?</p>
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
            let record = null

            $('#records').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [4],
                }, {
                    "searchable": false, "targets": [0, 4],
                }]
            })

            $(document).on('click', '.delete-record', function(e) {
                e.preventDefault()
                record = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/sub') }}/' + record)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                record = null
                $('#deleteModal form').attr('action', '')
            })
        })
    </script>
@endsection
