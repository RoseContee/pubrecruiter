@extends('admin.partials.layout')

@section('title', 'Recommendations')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Recommendations</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Recommendations</li>
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
                            <a href="{{ route('admin.recommendations.create') }}" class="btn btn-primary">Add Recommendation</a>
                        </div>
                        <div class="card-body">
                            <table id="recommendations" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>User</th>
                                    <th>Recommendation</th>
                                    <th>Notes</th>
                                    <th>Average Response</th>
                                    <th>Date</th>
                                    <th style="width: 55px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($recommendations as $index => $recommendation)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $recommendation['user']['name'] ?? '' }}</td>
                                        <td>{{ $recommendation['recommendation']['name'] ?? '' }}</td>
                                        <td>{{ $recommendation['note'] }}</td>
                                        <td>
                                            @switch($recommendation['response_time'])
                                                @case(1) 1 Hour @break
                                                @case(2) 1 Day @break
                                                @case(3) 1 Week @break
                                                @case(4) 1 Month
                                            @endswitch
                                        </td>
                                        <td>{{ date('n/j/y', strtotime($recommendation['created_at'])) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.recommendations.edit', $recommendation['id']) }}"
                                                    class="text-primary m-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-ref="{{ $recommendation['id'] }}"
                                                    class="text-danger m-1 delete-recommendation">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Recommendation</th>
                                    <th>Notes</th>
                                    <th>Average Response</th>
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
                        <h4 class="modal-title">Delete Recommendation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this recommendation?</p>
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
            let recommendation = null

            $('#recommendations').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [6],
                }, {
                    "searchable": false, "targets": [0, 6],
                }]
            })

            $(document).on('click', '.delete-recommendation', function(e) {
                e.preventDefault()
                recommendation = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/recommendations') }}/' + recommendation)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                recommendation = null
                $('#deleteModal form').attr('action', '')
            })
        })
    </script>
@endsection
