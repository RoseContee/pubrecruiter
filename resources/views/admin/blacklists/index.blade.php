@extends('admin.partials.layout')

@section('title', 'Blacklist')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blacklists</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blacklists</li>
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
                            <button class="btn btn-primary add-website">Add Website</button>
                        </div>
                        <div class="card-body">
                            <table id="websites" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>Domain</th>
                                    <th style="width: 45px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($blacklists as $index => $site)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $site['domain'] }}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" data-ref="{{ $site['id'] }}"
                                                    class="text-danger m-1 delete-website">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Domain</th>
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

    <!-- Add Modal -->
    <div id="addModal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.blacklists.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Add Website</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" id="website" name="website"
                                   class="form-control @if ($errors->has('website') || $errors->has('domain')) is-invalid @endif"
                                   value="{{ old('website') }}"
                                   placeholder="Enter website url" required>
                            @if ($errors->has('website') || $errors->has('domain'))
                                <label class="small text-danger font-weight-normal mb-0">
                                    {{ $errors->has('website') ? $errors->first('website') : $errors->first('domain') }}
                                </label>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Website</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this website from the blacklist?</p>
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
            let blacklist = null

            $('#websites').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [2],
                }, {
                    "searchable": false, "targets": [0, 2],
                }]
            })

            $(document).on('click', '.add-website', function(e) {
                e.preventDefault()
                $('#addModal').modal('show').find('#website').val('')
            })

            $(document).on('click', '.delete-website', function(e) {
                e.preventDefault()
                blacklist = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/blacklists') }}/' + blacklist)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                blacklist = null
                $('#deleteModal').find('form').attr('action', '')
            })

            @if ($errors->has('website') || $errors->has('domain'))
                $('#addModal').modal('show')
            @endif
        })
    </script>
@endsection
