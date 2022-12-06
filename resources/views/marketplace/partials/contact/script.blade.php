@if (auth()->check())
    <script type="text/javascript">
        $(function() {
            $(document).on('click', '.favorite-brand:not(.disabled)', function() {
                const that = $(this), favorite = that.find('i')
                that.addClass('disabled')
                if (favorite.hasClass('far')) {
                    favorite.removeClass('far').addClass('fa')
                } else {
                    favorite.removeClass('fa').addClass('far')
                }
                $.ajax({
                    url: '{{ route('favorite-brand') }}',
                    method: 'POST',
                    data: {
                        contact: that.data('ref'),
                    },
                    success(data) {
                        if (data.success) {
                            if (data.status) {
                                favorite.removeClass('far').addClass('fa')
                            } else {
                                favorite.removeClass('fa').addClass('far')
                            }
                            that.removeClass('disabled')
                        } else {
                            alert(data.message)
                        }
                    },
                    error(data) {
                        location.reload()
                    }
                })
            })

            $(document).on('click', '.request-partnership:not(:disabled)', function() {
                const that = $(this)
                window.open(that.data('href'))
                $.ajax({
                    url: '{{ route('request-partnership') }}',
                    method: 'POST',
                    data: {
                        contact: that.data('ref'),
                    },
                    success(data) {
                        if (data.success) {
                            that.html('<i class="fa fa-check"></i>').removeClass('request-partnership')
                            @if (auth()->user()->type == 'Creator')
                                $.ajax({
                                    url: '{{ route('network-signup') }}',
                                    method: 'POST',
                                    data: {
                                        contact: $(this).data('ref'),
                                    }
                                })
                                that.html('<i class="fa fa-spinner fa-spin"></i>').attr('disabled', 'disabled')
                            @endif
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
        })
    </script>
@else
    <div id="signinModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p>Sign in to continue</p>
                    <a href="{{ route('login') }}" class="btn btn-success">
                        Continue
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

@if (!auth()->check() || auth()->user()->type == 'Brand')
    <!-- Opportunity Modal Start-->
    <div id="opportunitiesModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Opportunities</h5>
                    <a href="javascript:void(0);" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="modal-body">
                    @auth
                        <div id="opportunities-success-message" class="alert alert-success fade show display-none">
                            <span>Your inquiry has been sent successfully.</span>
                            <a href="javascript:void(0);" class="close" onclick="$(this).parent().hide();">&times;</a>
                        </div>
                        <div id="opportunities-error-message" class="alert alert-danger fade show display-none">
                            <span>Something went wrong.</span>
                            <a href="javascript:void(0);" class="close" onclick="$(this).parent().hide();">&times;</a>
                        </div>
                    @endauth
                    <div class="input-group text-center mb-0 opportunities-header">
                        <div class="form-control font-weight-bold border-0 justify-content-center p-0 text-dark small">Description</div>
                        <div class="input-group-append">
                            <span class="input-group-text font-weight-bold border-0 bg-white p-0 text-dark small">Price</span>
                            <span class="input-group-text font-weight-bold border-0 bg-white p-0 text-dark small">Select</span>
                        </div>
                    </div>
                    <div id="opportunities-list"></div>
                    @auth
                        <div id="opportunities-error" class="text-center text-danger small mb-2 display-none">
                            Please select an opportunity.
                        </div>
                        <p id="media-kit-link" class="text-center mb-2"></p>
                    @endauth
                    <button id="opportunities-inquiry" class="btn btn-main btn-sm btn-block" disabled>
                        Send Inquiry
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Opportunity Modal End-->

    <script type="text/javascript">
        let contact = null
        @auth let sendingInquiry = false @endauth

        $(function() {
            $(document).on('click', '.view-opportunities', function() {
                try {
                    $(this).data('opportunities').forEach(function (opportunity) {
                        $('#opportunities-list').append(opportunityItem(opportunity))
                    })
                    const link = $(this).data('media-kit')
                    if (link) {
                        $('#media-kit-link').html(`<a href="${link}" target="_blank">Media Kit Link</a>`)
                    } else {
                        $('#media-kit-link').html('')
                    }
                    contact = $(this).data('ref')
                    $('#opportunitiesModal').modal('show')
                } catch (e) {
                    alert('Something went wrong.')
                    location.reload()
                }
            })

            $(document).on('change', '[name="opportunities[]"]', function() {
                if ($('[name="opportunities[]"]:checked').length) {
                    $('#opportunities-inquiry').removeAttr('disabled')
                    $('#opportunities-error').hide()
                } else {
                    $('#opportunities-inquiry').attr('disabled', 'disabled')
                }
            })

            $(document).on('click', '#opportunities-inquiry:not(:disabled)', function() {
                @if (auth()->check())
                    let that = $(this), opportunities = []
                    $('[name="opportunities[]"]:checked').each(function() {
                        opportunities.push($(this).val())
                    })
                    if (!opportunities.length) {
                        return $('#opportunities-error').html('Please select an opportunity.').show()
                    }
                    that.html('<i class="fa fa-spinner fa-spin"></i>').attr('disabled', 'disabled')
                    sendingInquiry = true
                    $.ajax({
                        url: '{{ route('opportunities-inquiry') }}',
                        method: 'POST',
                        data: {
                            contact: contact,
                            opportunities: opportunities,
                        },
                        success(data) {
                            sendingInquiry = false
                            if (data.success) {
                                $('#opportunities-success-message').show()
                            } else {
                                alert(data.message)
                            }
                            that.html('Send Inquiry').removeAttr('disabled')
                        },
                        error(data) {
                            if (data.status == 400) {
                                sendingInquiry = false
                                $('#opportunities-error').html(data.responseJSON.errors.opportunities[0]).show()
                                that.html('Send Inquiry').removeAttr('disabled')
                            } else {
                                $('#opportunities-error-message').show()
                                setTimeout(() => location.reload(), 2000)
                            }
                        }
                    })
                @else
                    $('#opportunitiesModal').removeClass('fade').modal('hide').addClass('fade')
                    $('#signinModal').modal('show')
                @endif
            })

            $('#opportunitiesModal')
            @auth
                .on('hide.bs.modal', function (e) {
                    if (sendingInquiry) {
                        e.preventDefault()
                        e.stopPropagation()
                        return false
                    }
                })
            @endauth
            .on('hidden.bs.modal', function(e) {
                contact = null
                $('#opportunities-success-message').hide()
                $('#opportunities-error-message').hide()
                $('#opportunities-list').html('')
                $('#opportunities-error').hide()
                $('#opportunities-inquiry').html('Send Inquiry').attr('disabled', 'disabled')
            })
        })

        function opportunityItem(opportunity) {
            const description = opportunity.description
            const price = opportunity.cost_type == 'dollar' ? `$${opportunity.cost}` : opportunity.cost_type
            const ref = opportunity.id
            return `<label class="input-group">
                        <div class="form-control px-2">${description}</div>
                        <div class="input-group-append">
                            <span class="input-group-text px-1 small">${price}</span>
                            <div class="input-group-text justify-content-center bg-white">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="opportunities[]" value="${ref}"
                                           class="custom-control-input">
                                    <span class="custom-control-label"></span>
                                </div>
                            </div>
                        </div>
                    </label>`
        }
    </script>
@endif
