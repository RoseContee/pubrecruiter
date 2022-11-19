@extends('admin.partials.layout')

@section('title', 'Feedback')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Feedback</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Feedback</li>
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
                            <table id="feedback" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>Website</th>
                                    <th>Response Time</th>
                                    <th>Comment</th>
                                    <th>Submitted By</th>
                                    <th style="width: 55px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($feedbacks as $index => $feedback)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $feedback['domain'] }}</td>
                                        <td>
                                            @switch($feedback['response_time'])
                                                @case(1) 1 Hour @break
                                                @case(2) 1 Day @break
                                                @case(3) 1 Week @break
                                                @case(4) 1 Month
                                            @endswitch
                                        </td>
                                        <td style="word-break: break-all">{{ $feedback['comment'] }}</td>
                                        <td>{{ $feedback['user']['email'] ?? '' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.feedback.show', $feedback['id']) }}"
                                                    class="text-primary m-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-ref="{{ $feedback['id'] }}"
                                                    class="text-danger m-1 delete-feedback">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Website</th>
                                    <th>Response Time</th>
                                    <th>Comment</th>
                                    <th>Submitted By</th>
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
                        <h4 class="modal-title">Delete Feedback</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this feedback?</p>
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
            let feedback = null

            $('#feedback').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [5],
                }, {
                    "searchable": false, "targets": [0, 5],
                }]
            })

            $(document).on('click', '.delete-feedback', function(e) {
                e.preventDefault()
                feedback = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/feedback') }}/' + feedback)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                feedback = null
                $('#deleteModal form').attr('action', '')
            })
        })
    </script>
@endsection
