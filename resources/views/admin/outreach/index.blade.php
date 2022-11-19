@extends('admin.partials.layout')

@section('title', 'Outreach')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Outreach</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Outreach</li>
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
                            <table id="outreaches" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>Name</th>
                                    <th>Website</th>
                                    <th class="py-0">Network /<br>Opportunity</th>
                                    <th style="width: 186px;">Interested In</th>
                                    <th>Submitted By</th>
                                    <th class="py-0">Referral<br>Code</th>
                                    <th style="width: 45px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($outreaches as $index => $outreach)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $outreach['contact']->contact_name() }}</td>
                                        <td>
                                            <a href="{{ $outreach['contact']['website'] }}" target="_blank">
                                                {{ $outreach['contact']['website'] }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($outreach['opportunities'])
                                                @foreach ($outreach['opportunities'] as $opportunity)
                                                    <p class="small mb-2" style="line-height:1.2;">{{ $opportunity['description'] }}
                                                        <b>{{ $opportunity['cost_type'] == 'dollar' ? '$'.$opportunity['cost'] : $opportunity['cost_type'] }}</b></p>
                                                @endforeach
                                            @elseif ($outreach['contact']['network'])
                                                <a href="{{ $outreach['contact']['network_link'] }}" target="_blank">
                                                    {{ $outreach['contact']['network'] }}
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($outreach['opportunities'])
                                                <span class="badge badge-primary">
                                                    Opportunity Submission
                                                </span>
                                            @else
                                                <span class="badge @if ($outreach['contact']['offers']) badge-info @else invisible @endif">
                                                    Affiliate Offers
                                                </span>
                                                <span class="badge @if ($outreach['contact']['posts']) badge-success @else invisible @endif">
                                                    Sponsored Posts
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $outreach['user']['email'] ?? '' }}</td>
                                        <td>{{ $outreach['user']['info']['referral']['code'] ?? '' }}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" data-ref="{{ $outreach['id'] }}"
                                                    class="text-danger m-1 delete-outreach">
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
                                    <th>Website</th>
                                    <th class="py-0">Network /<br>Opportunity</th>
                                    <th>Interested In</th>
                                    <th>Submitted By</th>
                                    <th class="py-0">Referral<br>Code</th>
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
                        <h4 class="modal-title">Delete Outreach</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this outreach?</p>
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
            let outreach = null

            $('#outreaches').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [4, 7],
                }, {
                    "searchable": false, "targets": [0, 7],
                }]
            })

            $(document).on('click', '.delete-outreach', function(e) {
                e.preventDefault()
                outreach = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/outreach') }}/' + outreach)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                outreach = null
                $('#deleteModal form').attr('action', '')
            })
        })
    </script>
@endsection
