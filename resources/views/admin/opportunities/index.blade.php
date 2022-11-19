@extends('admin.partials.layout')

@section('title', 'Opportunities')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Opportunities</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Opportunities</li>
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
                            <table id="opportunities" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>Email</th>
                                    <th>Description</th>
                                    <th>Cost</th>
                                    <th style="width: 45px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($opportunities as $index => $opportunity)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $opportunity['user']['email'] ?? '' }}</td>
                                        <td>{{ $opportunity['description'] }}</td>
                                        <td>
                                            @if ($opportunity['cost_type'] == 'dollar')
                                                ${{ $opportunity['cost'] }}
                                            @else
                                                {{ $opportunity['cost_type'] }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" data-ref="{{ $opportunity['id'] }}"
                                                    class="text-danger m-1 delete-opportunity">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Description</th>
                                    <th>Cost</th>
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
                        <h4 class="modal-title">Delete Opportunity</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this opportunity?</p>
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
            let opportunity = null

            $('#opportunities').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [4],
                }, {
                    "searchable": false, "targets": [0, 4],
                }]
            })

            $(document).on('click', '.delete-opportunity', function(e) {
                e.preventDefault()
                opportunity = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/opportunities') }}/' + opportunity)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                opportunity = null
                $('#deleteModal form').attr('action', '')
            })
        })
    </script>
@endsection
