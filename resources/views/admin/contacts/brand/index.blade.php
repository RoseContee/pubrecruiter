@extends('admin.partials.layout')

@section('title', 'Brands')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contacts ({{ ucfirst($submenu) }})</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Contacts</li>
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
                            <a href="{{ route('admin.contacts.create', ['type' => $submenu]) }}" class="btn btn-primary">Add Brand</a>
                        </div>
                        <div class="card-body">
                            <table id="contacts" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 20px;">No</th>
                                    <th>Show</th>
                                    <th>Featured</th>
                                    <th>Contact Email</th>
                                    <th>Brand Name</th>
                                    <th>Brand URL</th>
                                    <th>Logo</th>
                                    <th>Tags</th>
                                    <th>Network</th>
                                    <th style="width: 55px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($contacts as $index => $contact)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>
                                            @if ($contact['active'])
                                                <span class="badge badge-success">Show</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($contact['featured'])
                                                <span class="badge badge-info">Featured</span>
                                            @endif
                                        </td>
                                        <td>{{ $contact->contact_email() }}</td>
                                        <td>{{ $contact->contact_name() }}</td>
                                        <td>
                                            <a href="{{ $contact['website'] }}" target="_blank">
                                                {{ $contact['website'] }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($contact['logo'] && file_exists(public_path($contact['logo'])))
                                                <img src="{{ asset('public/'.$contact['logo']) }}"
                                                     class="img-fluid" alt="{{ $contact['name'] }}" style="width:120px;">
                                            @endif
                                        </td>
                                        <td>{{ $contact['tags'] }}</td>
                                        <td>
                                            <a href="{{ $contact['network_link'] }}" target="_blank">
                                                {{ $contact['network'] }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.contacts.show', $contact['id']) }}"
                                                    class="text-primary m-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-ref="{{ $contact['id'] }}"
                                                    class="text-danger m-1 delete-contact">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Show</th>
                                    <th>Featured</th>
                                    <th>Contact Email</th>
                                    <th>Brand Name</th>
                                    <th>Brand URL</th>
                                    <th>Logo</th>
                                    <th>Tags</th>
                                    <th>Network</th>
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
                        <h4 class="modal-title">Delete Contact</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this contact?</p>
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
            let contact = null

            $('#contacts').DataTable({
                "responsive": true,
                "lengthMenu": [100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [6, 9],
                }, {
                    "searchable": false, "targets": [0, 6, 9],
                }]
            })

            $(document).on('click', '.delete-contact', function(e) {
                e.preventDefault()
                contact = $(this).data('ref')
                $('#deleteModal').modal('show').find('form').attr('action', '{{ url('admin/contacts') }}/' + contact)
            })

            $('#deleteModal').on('hidden.bs.modal', function () {
                contact = null
                $('#deleteModal form').attr('action', '')
            })
        })
    </script>
@endsection
