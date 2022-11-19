@extends('marketplace.dashboard.layout')

@section('title', 'Opportunities')

@push('style')
    <style type="text/css">
        .description {
            word-break: break-all;
        }
    </style>
@endpush

@section('content')
    <!--Main Start-->
    <main id="main-container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Media Kit Link
                </h3>
            </div>
            <div class="card-body">
                @if (empty($info['media_kit_link']))
                    <div class="row">
                        <div class="col-12">
                            <a href="javascript:void(0);"
                               class="btn btn-main btn-sm"  data-toggle="modal" data-target="#mediaKitModal">
                                <i class="fa fa-plus-circle"></i> Add Media Kit Link
                            </a>
                        </div>
                    </div>
                @else
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th>Link</th>
                            <th style="width:60px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $info['media_kit_description'] }}</td>
                            <td>
                                <a href="{{ $info['media_kit_link'] }}" target="_blank">{{ $info['media_kit_link'] }}</a>
                            </td>
                            <td class="text-center px-1">
                                <a href="javascript:void(0);" class="btn text-info p-0" data-toggle="modal" data-target="#mediaKitModal">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn text-main p-0" data-toggle="modal" data-target="#deleteMediaKitModal">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Opportunities
                </h3>
            </div>
            <div class="card-body">
                @if (count($opportunities) < 5)
                    <div class="row mb-3">
                        <div class="col-12">
                            <a href="javascript:void(0);"
                               class="btn btn-main btn-sm add-opportunity">
                                <i class="fa fa-plus-circle"></i> Add New
                            </a>
                        </div>
                    </div>
                @endif
                <table id="opportunities" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width:20px;">No</th>
                        <th>Description</th>
                        <th>Cost</th>
                        <th style="width:60px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($opportunities as $index => $opportunity)
                        <tr>
                            <td class="text-center">{{ ++$index }}</td>
                            <td class="description">{{ $opportunity['description'] }}</td>
                            <td class="cost">{{ $opportunity['cost_type'] == 'dollar' ? '$'.$opportunity['cost'] : $opportunity['cost_type'] }}</td>
                            <td data-ref="{{ $opportunity['id'] }}">
                                <a href="javascript:void(0);" class="btn text-info px-1 py-0 edit-opportunity">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn text-main px-1 py-0 delete-opportunity">
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
    <!-- Media Kit Modal Start-->
    <div id="mediaKitModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Media Kit Link</h5>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="{{ route('media-kit.store') }}" method="POST">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" id="description" name="description" class="form-control @error('description', 'media') is-invalid @enderror"
                                   value="{{ old('description', $info['media_kit_description']??'') }}" maxlength="50"
                                   placeholder="Add description">
                            @error('description', 'media')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="url" id="link" name="link" class="form-control @error('link', 'media') is-invalid @enderror"
                                   value="{{ old('link', $info['media_kit_link']??'') }}" required
                                   placeholder="Add link">
                            @error('link', 'media')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-main btn-sm btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Media Kit Modal End-->

    <!-- Delete Media Kit Modal Start-->
    <div id="deleteMediaKitModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Opportunity</h5>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="{{ route('media-kit.destroy') }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <p>Are you sure to delete media kit link?</p>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                            <button class="btn btn-danger btn-sm">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Media Kit Modal End-->

    <!-- Opportunity Modal Start-->
    <div id="opportunityModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Opportunity</h5>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <form id="opportunityForm" action="" method="POST">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" id="description" name="description" class="form-control @error('description', 'opportunity') is-invalid @enderror"
                                   value="{{ old('description') }}" required
                                   placeholder="Add description">
                            @error('description', 'opportunity')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Cost</label>
                            <div class="row @error('cost_type') is-invalid @enderror">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <div class="custom-control custom-radio">
                                        <input id="cost-dollar" type="radio" name="cost_type" class="custom-control-input"
                                               value="dollar" @if (old('cost_type') == 'dollar') checked @endif>
                                        <span class="custom-control-label"></span>
                                        <label for="cost-dollar" class="cursor-pointer">Dollar($)</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="custom-control custom-radio">
                                        <input id="cost-contact" type="radio" name="cost_type" class="custom-control-input"
                                               value="Contact for Pricing" @if (old('cost_type') != 'dollar') checked @endif>
                                        <span class="custom-control-label"></span>
                                        <label for="cost-contact" class="cursor-pointer">Contact for Pricing</label>
                                    </div>
                                </div>
                            </div>
                            @error('cost_type')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="dollar" class="form-group" style="display: none;">
                            <label for="amount">Amount</label>
                            <input type="number" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ old('amount') }}"
                                   placeholder="Enter amount">
                            @error('amount')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-main btn-sm btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Opportunity Modal End-->

    <!-- Delete Opportunity Modal Start-->
    <div id="deleteOpportunityModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Opportunity</h5>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <p>Are you sure to delete this opportunity?</p>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                            <button class="btn btn-danger btn-sm">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Opportunity Modal End-->

    <script type="text/javascript">
        const add_link = '{{ route('opportunities.store') }}'
        const edit_link = '{{ route('opportunities.update', 'EDIT_ID') }}'
        const delete_link = '{{ route('opportunities.destroy', 'DELETE_ID') }}'

        const opportunityForm = $('#opportunityForm')
        const opportunityModal = $('#opportunityModal')

        const deleteOpportunityModal = $('#deleteOpportunityModal')

        $(function() {
            $('#opportunities').DataTable({
                "responsive": true,
                "lengthMenu": [10, 25, 50, 100, 250, 500],
                "autoWidth": false,
                "columnDefs": [{
                    "sortable": false, "targets": [3],
                }, {
                    "searchable": false, "targets": [0, 3],
                }],
                "pagingType": "full_numbers",
                "language": {
                    "lengthMenu": "Display _MENU_ opportunities per page",
                    "zeroRecords": "Opportunities not found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ opportunities",
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

            $(document).on('click', '.add-opportunity', function() {
                initForm()
                opportunityModal.find('h2').text('Add Opportunity')
                opportunityForm.attr('action', add_link)
                opportunityModal.modal('show')
            })

            $(document).on('click', '.edit-opportunity', function() {
                initForm()

                const ref = $(this).parent().data('ref')
                const url = edit_link.replace('EDIT_ID', ref)
                opportunityModal.find('h2').text('Edit Opportunity')
                opportunityForm.attr('action', url)
                opportunityForm.find('[name="_method"]').val('PUT')

                const tr = $(this).parents('tr')
                const description = tr.find('.description').text().trim()
                $('#description').val(description)
                const cost = tr.find('.cost').text().trim()
                if (cost.substring(0, 1) === '$') {
                    $('#cost-dollar').prop('checked', true)
                    $('#dollar').show()
                    $('#amount').val(cost.substring(1)).attr('required', 'required')
                } else {
                    $('#cost-contact').prop('checked', true)
                    $('#dollar').hide()
                    $('#amount').val('').removeAttr('required')
                }
                opportunityModal.modal('show')
            })

            $(document).on('click', '.delete-opportunity', function() {
                const ref = $(this).parent().data('ref')
                const url = delete_link.replace('DELETE_ID', ref)
                deleteOpportunityModal.find('form').attr('action', url)
                deleteOpportunityModal.modal('show')
            })

            $('[name="cost_type"]').on('change', function() {
                if ($('[name="cost_type"]:checked').val() === 'dollar') {
                    $('#dollar').show()
                    $('#amount').attr('required', 'required')
                } else {
                    $('#dollar').hide()
                    $('#amount').removeAttr('required')
                }
            })

            opportunityModal.on('hidden.bs.modal', function() {
                initForm()
            })

            deleteOpportunityModal.on('hidden.bs.modal', function() {
                deleteOpportunityModal.find('form').attr('action', '')
            })

            @if ($errors->opportunity->any())
                opportunityModal.find('h2').text('Add Opportunity')
                opportunityForm.attr('action', add_link)
                opportunityModal.modal('show')
            @elseif ($errors->media->any())
                $('#mediaKitModal').modal('show')
            @endif
        })

        function initForm() {
            opportunityModal.find('h2').text('Add Opportunity')
            opportunityForm.attr('action', '')
            opportunityForm.find('[name="_method"]').val('POST')
            opportunityForm.find('.is-invalid').removeClass('is-invalid').next().remove()
            opportunityForm.find('.form-control').val('')
            opportunityForm.find('#cost-contact').prop('checked', true)
            $('#dollar').hide()
            opportunityForm.find('#amount').removeAttr('required')
        }
    </script>
@endpush
