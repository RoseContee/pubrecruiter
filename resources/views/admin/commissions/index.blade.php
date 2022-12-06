@extends('admin.partials.layout')

@section('title', 'Commissions')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Commissions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Commissions</li>
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
                            <a href="{{ route('admin.commissions.create') }}" class="btn btn-primary">Add Commission</a>
                        </div>
                        <div class="card-body">
                            <table id="commissions" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>Creator Name</th>
                                    <th>Brand</th>
                                    <th>Date of Transaction</th>
                                    <th>Creator Commission Amount</th>
                                    <th>Pub Recruiter Commission</th>
                                    <th>Paid?</th>
                                    <th style="width: 55px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($commissions as $index => $commission)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $commission['user']['name'] ?? null }}</td>
                                        <td>{{ $commission['brand'] }}</td>
                                        <td>{{ $commission['date'] }}</td>
                                        <td>${{ $commission['commission'] ?: 0 }}</td>
                                        <td>${{ $commission['admin_commission'] ?: 0 }}</td>
                                        <td>{{ $commission['paid'] ? 'Yes' : 'No' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.commissions.show', $commission['id']) }}"
                                               class="text-primary m-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-ref="{{ $commission['id'] }}"
                                                    class="text-danger m-1 delete-commission">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Creator Name</th>
                                    <th>Brand</th>
                                    <th>Date of Transaction</th>
                                    <th>Creator Commission Amount</th>
                                    <th>Pub Recruiter Commission</th>
                                    <th>Paid?</th>
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
                        <h4 class="modal-title">Delete Commission</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this commission?</p>
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
            let commission = null

            $('#commissions').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [7],
                }, {
                    "searchable": false, "targets": [0, 7],
                }]
            })

            $(document).on('click', '.delete-commission', function(e) {
                e.preventDefault()
                commission = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/commissions') }}/' + commission)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                commission = null
                $('#deleteModal form').attr('action', '')
            })
        })
    </script>
@endsection
