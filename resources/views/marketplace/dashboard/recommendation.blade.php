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
                    Recommended Partners
                </h3>
            </div>
            <div class="card-body">
                <table id="favorites" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width:20px;">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Avg Response Time</th>
                        <th>Note from Pub Recruiter</th>
                        <th>Inquiry</th>
                        <th>Bounty Tip</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($recommendations as $index => $recommendation)
                        <tr>
                            <td class="text-center">{{ ++$index }}</td>
                            <td>{{ $recommendation['recommendation']['name'] ?? '' }}</td>
                            <td>{{ $recommendation['recommendation']['email'] ?? '' }}</td>
                            <td>
                                @switch($recommendation['response_time'])
                                    @case(1) 1 Hour @break
                                    @case(2) 1 Day @break
                                    @case(3) 1 Week @break
                                    @case(4) 1 Month
                                @endswitch
                            </td>
                            <td>{{ $recommendation['note'] }}</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-block request-partnership"
                                        data-ref="{{ $recommendation['id'] }}">
                                    Request
                                </button>
                            </td>
                            <td>
                                @if (!empty($setting['stripe_link']))
                                    <a href="{{ $setting['stripe_link'] }}" class="btn btn-success btn-sm btn-block">Tip</a>
                                @endif
                            </td>
                            <td>{{ date('n/j/y', strtotime($recommendation['created_at'])) }}</td>
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
                    "sortable": false, "targets": [5, 6],
                }, {
                    "searchable": false, "targets": [0, 5, 6],
                }],
                "pagingType": "full_numbers",
                "language": {
                    "lengthMenu": "Display _MENU_ partners per page",
                    "zeroRecords": "Partners not found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ partners",
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

            $(document).on('click', '.request-partnership', function() {
                const that = $(this)
                that.html('<i class="fa fa-spinner fa-spin"></i>').attr('disabled', 'disabled')
                $.ajax({
                    url: '{{ route('recommendation-partnership') }}',
                    method: 'POST',
                    data: {
                        recommendation: that.data('ref'),
                    },
                    success(data) {
                        if (data.success) {
                            that.html('<i class="fa fa-check"></i>').removeClass('request-partnership')
                        } else {
                            that.html('Request').removeAttr('disabled')
                            alert(data.message)
                        }
                    },
                    error(data) {
                        location.reload()
                    }
                })
            })
        })
    </script>
@endpush
