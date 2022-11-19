@extends('marketplace.dashboard.layout')

@section('title', $menu.' Requests')

@push('style')
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <style type="text/css">
        .notes {
            word-break: break-all;
        }

        #partnershipModal div.form-control {
            height: auto;
            min-height: calc(2.25rem + 2px);
        }
    </style>
@endpush

@php
    $brand_user = auth()->user()->type == 'Brand';
    $opportunity = ($menu == 'Inbound' && !$brand_user) || ($menu == 'Outbound' && $brand_user);
@endphp

@section('content')
    <!--Main Start-->
    <main id="main-container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    {{ $menu }} Partnership Requests
                </h3>
            </div>
            <div class="card-body">
                <table id="partnerships" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width:20px;">No</th>
                        <th>{{ $brand_user ? 'Name of website' : 'Brand Name' }}</th>
                        <th>Email</th>
                        @if ($opportunity)
                            <th class="py-1" style="width:80px;line-height:1.5;">Opportunity Inquiry</th>
                            <th>Opportunity Description</th>
                            @if ($brand_user)
                                <th class="py-1" style="width:60px;">Payment Sent?</th>
                                <th style="width:100px;">IO Date</th>
                                <th>Notes</th>
                                <th style="width:0"></th>
                            @endif
                        @endif
                        @if (!$opportunity || !$brand_user)
                            <th style="width:100px;">Date</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($partnerships as $index => $partnership)
                        <tr data-partnership="{{ $partnership['id'] }}">
                            <td class="text-center">{{ ++$index }}</td>
                            <td class="name-of-website">
                                @if ($menu == 'Inbound')
                                    {{ $partnership['user']['name'] }}
                                @else
                                    <a href="{{ $partnership['contact']['website'] }}" target="_blank">
                                        {{ $partnership['contact']->contact_name() }}
                                    </a>
                                @endif
                            </td>
                            <td class="email">
                                @if ($menu == 'Inbound')
                                    {{ $partnership['user']['email'] }}
                                @else
                                    {{ $partnership['contact']->contact_email() }}
                                @endif
                            </td>
                            @if ($opportunity)
                                <td class="opportunity">@if (count($partnership['opportunities'])) Yes @endif</td>
                                <td class="opportunity-description">
                                    @if (count($partnership['opportunities']))
                                        @foreach ($partnership['opportunities'] as $opportunity)
                                            <p class="text-truncate small @if ($loop->last) mb-0 @else mb-2 @endif" style="line-height:1.2;">
                                                {{ $opportunity['description'] }}
                                            </p>
                                        @endforeach
                                    @endif
                                </td>
                                @if ($brand_user)
                                    <td class="payment-sent">@if ($partnership['payment_sent']) Yes @endif</td>
                                    <td class="io-date">
                                        @if ($partnership['io_date'])
                                            <span data-io-date="{{ $partnership['io_date'] }}">
                                                {{ date('n/j/y', strtotime($partnership['io_date'])) }}
                                            </span>
                                        @else
                                            <span></span>
                                        @endif
                                    </td>
                                    <td class="notes">{{ $partnership['notes'] }}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn text-main p-0 edit-partnership"
                                           data-partnership="{{ $partnership['id'] }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                @endif
                            @endif
                            @if (!$opportunity || !$brand_user)
                                <td>
                                    {{ date('n/j/y', strtotime($partnership['created_at'])) }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection

@push ('script')
    <script type="text/javascript">
        $(function() {
            $('#partnerships').DataTable({
                "responsive": true,
                "lengthMenu": [10, 25, 50, 100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [@if ($opportunity && $brand_user) 8 @endif],
                }, {
                    "searchable": false, "targets": [0 @if ($opportunity && $brand_user) ,8 @endif],
                }],
                "pagingType": "full_numbers",
                "language": {
                    "lengthMenu": "Display _MENU_ requests per page",
                    "zeroRecords": "Partnership requests not found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ requests",
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
        })
    </script>

    @if ($opportunity && $brand_user)
        <!-- Partnership Modal Start-->
        <div id="partnershipModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Your Outbound</h5>
                        <a href="javascript:void(0)" class="close" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div id="partnership-success-message" class="alert alert-success display-none">
                            <span></span>
                            <a href="javascript:void(0);" class="close" onclick="$(this).parent().hide()"><i class="fa fa-times"></i></a>
                        </div>
                        <div id="partnership-error-message" class="alert alert-danger display-none">
                            <span></span>
                            <a href="javascript:void(0);" class="close" onclick="$(this).parent().hide()"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="form-group">
                            <label>Name Of Website</label>
                            <div id="name-of-website" class="form-control" readonly></div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <div id="email" class="form-control" readonly></div>
                        </div>
                        <div class="form-group">
                            <label>Opportunity Inquiry</label>
                            <div id="opportunity" class="form-control" readonly></div>
                        </div>
                        <div class="form-group">
                            <label>Opportunity Description</label>
                            <div id="opportunity-description" class="form-control" readonly></div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="payment_sent" class="custom-control-input">
                                <span class="custom-control-label"></span>
                                <label for="payment_sent" class="cursor-pointer">Payment Sent?</label>
                            </div>
                            <div id="payment_sent-error" class="text-danger small display-none"></div>
                        </div>
                        <div class="form-group">
                            <label for="io_date">IO Date</label>
                            <input type="text" id="io_date" class="form-control" placeholder="Add date"
                                   data-target="#timepicker" data-toggle="datetimepicker">
                            <div id="io_date-error" class="text-danger small display-none"></div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <input type="text" id="notes" class="form-control" maxlength="75" placeholder="Add notes">
                            <div id="notes-error" class="text-danger small display-none"></div>
                        </div>
                        <button id="submit-partnership" class="btn btn-main btn-sm btn-block">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Partnership Modal End-->

        <!-- InputMask -->
        <script src="{{ asset('public/assets/vendor/moment/moment.min.js') }}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{ asset('public/assets/vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

        <script type="text/javascript">
            $(function() {
                $('#io_date').datetimepicker({
                    format: 'YYYY-MM-DD'
                })

                let partnership = null

                $(document).on('click', '.edit-partnership', function() {
                    let that = $(this)
                    partnership = that.data('partnership')
                    $('#partnership-success-message').hide().find('span').html('')
                    $('#partnership-error-message').hide().find('span').html('')
                    let parent1 = that.parents('tr'), parent2 = parent1, elem
                    if (parent1.hasClass('child') && parent1.prev().data('partnership') == partnership) {
                        parent2 = parent1.prev()
                    }
                    elem = ((elem = parent1.find('.name-of-website')).length && elem) || ((elem = parent2.find('.name-of-website')).length && elem)
                    $('#name-of-website').html(elem.html().trim())
                    elem = ((elem = parent1.find('.email')).length && elem) || ((elem = parent2.find('.email')).length && elem)
                    $('#email').html(elem.html().trim())
                    elem = ((elem = parent1.find('.opportunity')).length && elem) || ((elem = parent2.find('.opportunity')).length && elem)
                    $('#opportunity').html(elem.html().trim())
                    elem = ((elem = parent1.find('.opportunity-description')).length && elem) || ((elem = parent2.find('.opportunity-description')).length && elem)
                    $('#opportunity-description').html(elem.html().trim())
                    elem = ((elem = parent1.find('.payment-sent')).length && elem) || ((elem = parent2.find('.payment-sent')).length && elem)
                    $('#payment_sent').prop('checked', elem.html().trim() == 'Yes')
                    $('#payment_sent-error').html('').hide()
                    elem = ((elem = parent1.find('.io-date')).length && elem) || ((elem = parent2.find('.io-date')).length && elem)
                    $('#io_date').val(elem.find('span').data('io-date'))
                    $('#io_date-error').html('').hide()
                    elem = ((elem = parent1.find('.notes')).length && elem) || ((elem = parent2.find('.notes')).length && elem)
                    $('#notes').val(elem.html().trim())
                    $('#notes-error').html('').hide()
                    $('#partnershipModal').modal('show')
                })

                $(document).on('click', '#submit-partnership', function() {
                    if (!partnership) {
                        $('#partnership-error-message').show().find('span').text('Something went wrong.')
                        return
                    }
                    $('#partnership-error-message').hide().find('span').text('')
                    const payment_sent = $('#payment_sent').prop('checked') ? 1 : 0
                    const io_date = $('#io_date').val()
                    if (io_date && !moment(io_date, 'YYYY-MM-DD', true).isValid()) {
                        return $('#io_date-error').text('Date format is invalid.').show()
                    }
                    $('#io_date-error').text('').hide()
                    const notes = $('#notes').val()
                    if (notes.length > 75) {
                        $('#notes-error').text('The notes must not be greater than 75 characters.').show()
                    } else {
                        $('#notes-error').text('').hide()
                    }
                    $.ajax({
                        method: 'POST',
                        url: '{{ route('outbound') }}',
                        data: {
                            partnership: partnership,
                            payment_sent: payment_sent,
                            io_date: io_date,
                            notes: notes
                        },
                        success(data) {
                            let parent1 = $(`tr[data-partnership="${partnership}"]`), parent2 = parent1, elem
                            if (parent1.hasClass('parent')) parent2 = parent1.next()
                            elem = ((elem = parent1.find('.payment-sent')).length && elem) || ((elem = parent2.find('.payment-sent').length && elem))
                            elem.html(data.payment_sent ? 'Yes' : '')
                            elem = ((elem = parent1.find('.io-date')).length && elem) || ((elem = parent2.find('.io-date').length && elem))
                            elem.find('span').data('io-date', io_date).html(data.io_date)
                            elem = ((elem = parent1.find('.notes')).length && elem) || ((elem = parent2.find('.notes').length && elem))
                            elem.html(data.notes)
                            $('#partnershipModal').modal('hide')
                        },
                        error(data) {
                            console.log(data)
                            if (data.status == 400) {
                                for (const field in data.responseJSON) {
                                    const error = data.responseJSON[field]
                                    $(`#${field}-error`).text(error[0]).show()
                                }
                            } else {
                                alert('Something went wrong.')
                                location.reload()
                            }
                        }
                    })
                })

                $('#partnershipModal').on('hidden.bs.modal', function() {
                    partnership = null
                    $('#partnership-success-message').hide().find('span').html('')
                    $('#partnership-error-message').hide().find('span').html('')
                    $('#name-of-website').html('')
                    $('#email').html('')
                    $('#opportunity').html('')
                    $('#opportunity-description').html('')
                    $('#payment_sent').prop('checked', false)
                    $('#payment_sent-error').html('').hide()
                    $('#io_date').val('').datetimepicker('hide')
                    $('#io_date-error').html('').hide()
                    $('#notes').val('')
                    $('#notes-error').html('').hide()
                })
            })
        </script>
    @endif
@endpush
