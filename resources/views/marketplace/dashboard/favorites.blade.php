@extends('marketplace.dashboard.layout')

@php
    $brand_user = auth()->user()->type == 'Brand';
    $contact_type = $brand_user ? 'Creators' : 'Brands';
@endphp
@section('title', 'Favorite '.$contact_type)

@section('content')
    <!--Main Start-->
    <main id="main-container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Favorite {{ $contact_type }}
                </h3>
            </div>
            <div class="card-body">
                <table id="favorites" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width:20px;">No</th>
                        @if ($brand_user)
                            <th>Name of website</th>
                        @else
                            <th>Brand Name</th>
                        @endif
                        <th style="width:170px;">Request Partnership</th>
                        <th style="width:45px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($favorites as $index => $favorite)
                        <tr>
                            <td class="text-center">{{ ++$index }}</td>
                            <td>
                                {{ $favorite['contact']->contact_name() }}
                            </td>
                            <td>
                                @if (in_array($favorite['contact_id'], $sent))
                                    <button class="btn btn-info btn-sm btn-block" disabled>
                                        <i class="fa fa-check"></i>
                                    </button>
                                @else
                                    <button class="btn btn-info btn-sm btn-block request-partnership"
                                            data-ref="{{ $favorite['contact_id'] }}">
                                        Request Partnership
                                    </button>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="btn text-main px-1 py-0 remove-favorite"
                                   data-ref="{{ $favorite['contact_id'] }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection

@push('script')
    <script type="text/javascript">
        $(function() {
            $('#favorites').DataTable({
                "responsive": true,
                "lengthMenu": [10, 25, 50, 100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [2, 3],
                }, {
                    "searchable": false, "targets": [0, 2, 3],
                }],
                "pagingType": "full_numbers",
                "language": {
                    "lengthMenu": "Display _MENU_ {{ strtolower($contact_type) }} per page",
                    "zeroRecords": "Favorite {{ strtolower($contact_type) }} not found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ {{ strtolower($contact_type) }}",
                    "infoEmpty": "",
                    "infoFiltered": "(from _MAX_ total)",
                    "paginate": {
                        "first": '<i class="fa fa-angle-double-left"></i>',
                        "previous": '<i class="fa fa-angle-left"></i>',
                        "next": '<i class="fa fa-angle-right"></i>',
                        "last": '<i class="fa fa-angle-double-right"></i>'
                    }
                }
            })

            $(document).on('click', '.request-partnership:not(:disabled)', function() {
                const that = $(this)
                that.html('<i class="fa fa-spinner fa-spin"></i>').attr('disabled', 'disabled')
                $.ajax({
                    url: '{{ route('request-partnership') }}',
                    method: 'POST',
                    data: {
                        contact: that.data('ref'),
                    },
                    success(data) {
                        if (data.success) {
                            that.html('<i class="fa fa-check"></i>').removeClass('request-partnership')
                        } else {
                            that.html('Request Partnership').removeAttr('disabled')
                            alert(data.message)
                        }
                    },
                    error(data) {
                        location.reload()
                    }
                })
            })

            $(document).on('click', '.remove-favorite', function() {
                const that = $(this)
                that.html('<i class="fa fa-spinner fa-spin"></i>').addClass('disabled')
                $.ajax({
                    url: '{{ route('remove-favorite') }}',
                    method: 'DELETE',
                    data: {
                        contact: that.data('ref'),
                    },
                    success(data) {
                        location.reload()
                    },
                    error(data) {
                        alert('Something went wrong.')
                        location.reload()
                    }
                })
            })
        })
    </script>
@endpush
