@extends('admin.partials.layout')

@section('title', 'ADS')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ADS</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">ADS</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (!$active)
                <div class="alert alert-warning text-center">
                    ADS has been disabled.
                </div>
            @endif
            @include('admin.partials.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">Add AD</a>
                            @if ($active)
                                <button class="btn btn-danger ml-2" data-toggle="modal" data-target="#disableModal">
                                    Disable ADS
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id="ads" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>AD</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 55px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($ads as $index => $ad)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>
                                            @if ($ad['image'] && file_exists(public_path($ad['image'])))
                                                <a href="{{ $ad['link'] }}" target="_blank">
                                                    <img src="{{ asset('public/'.$ad['image']) }}"
                                                         class="img-fluid" alt="ADS" style="width:300px;height:45px;">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($ad['active'])
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.ads.show', $ad['id']) }}"
                                               class="text-primary m-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-ref="{{ $ad['id'] }}"
                                                    class="text-danger m-1 delete-ad">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>AD</th>
                                    <th>Status</th>
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
    <div id="disableModal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.ads.disable') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Disabled ADS</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to disable ads?</p>
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

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Delete AD</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this ad?</p>
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
            let ad = null

            $('#ads').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [1, 3],
                }, {
                    "searchable": false, "targets": [0, 1, 3],
                }]
            })

            $(document).on('click', '.delete-ad', function(e) {
                e.preventDefault()
                ad = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/ads') }}/' + ad)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                ad = null
                $('#deleteModal form').attr('action', '')
            })
        })
    </script>
@endsection
