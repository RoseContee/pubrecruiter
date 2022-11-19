<li class="nav-item dropdown notification-area">
    <a href="javascript:void(0);" class="nav-link text-gray">
        <i class="far fa-bell fa-2x"></i>
        <span class="noti-number badge badge-danger navbar-badge">{{ $noti }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="row p-2">
            <div class="col-sm-6 d-none d-sm-block">
                Notifications
            </div>
            <div class="col-sm-6 text-right">
                <a href="javascript:void(0);" class="not-seen"
                   data-ref="all">
                    Clear All
                </a>
            </div>
        </div>
        <ul id="notifications-list">
            @include('marketplace.partials.notifications.items')

            <li class="no-noti @if ($noti) display-none @endif">
                <a href="javascript:void(0);">
                    No notifications
                </a>
            </li>
        </ul>
    </div>
</li>

@push('script')
    <script type="text/javascript">
        $(function() {
            $(document).on('click', '.not-seen', function() {
                if (!$('#notifications-list li.noti').length) return
                const that = $(this), ref = that.data('ref'), noti = $('.noti-number')
                $.ajax({
                    url: '{{ route('partnership-seen') }}',
                    method: 'POST',
                    data: {
                        ref: ref,
                    },
                    success(data) {
                        if (ref == 'all') {
                            $('#notifications-list li.noti').remove()
                        } else {
                            that.remove()
                        }
                        const number = $('#notifications-list li.noti').length
                        noti.text(number)
                        if (!number) $('.no-noti').show()
                    },
                    error(data) {
                        location.reload()
                    }
                })
            })

            setTimeout(getNoti, 2000)
        })

        function getNoti() {
            $.ajax({
                url: '{{ route('get-noti') }}',
                method: 'GET',
                success(data) {
                    $('.noti-number').text(data.noti)
                    $('#notifications-list li.noti').remove()
                    $('#notifications-list').prepend(data.notis)
                    if (data.noti) $('.no-noti').hide()
                    else $('.no-noti').show()
                    setTimeout(getNoti, 2000)
                },
                error(data) {
                    location.reload()
                }
            })
        }
    </script>
@endpush
