<div id="contacts-list" class="row @if (!empty($menu)) pt-3 pt-md-0 @endif">
    @forelse ($contacts as $contact)
        @include('marketplace.partials.contact.item', [
            'class' => $class ?? null
        ])
    @empty
        <div class="col-12 text-center py-5">
            <h4 class="my-5 py-3 font-weight-normal">No {{ ucfirst($contact_type) }} Found</h4>
        </div>
    @endforelse
</div>
<div class="row">
    @if ($contacts->hasMorePages())
        <div class="col-12 text-center">
            <button id="load-more" class="btn btn-main btn-sm small"
                    data-next="{{ $contacts->nextPageUrl() }}">
                <i class="fa fa-spinner fa-spin display-none"></i> Load More
            </button>
        </div>
    @endif
</div>

@push('script')
    @include('marketplace.partials.contact.script')

    <script type="text/javascript">
        $(function() {
            $(document).on('click', '#load-more:not(:disabled)', function() {
                let that = $(this), url = that.data('next')
                if (!url) return that.parent().remove()
                that.attr('disabled', 'disabled').find('i').show()
                $.ajax({
                    url: url,
                    method: 'GET',
                    success(data) {
                        if (data.contacts) {
                            $('#contacts-list').append(data.contacts)
                            $('[data-toggle="tooltip"]').tooltip()
                        }
                        if (data.next) {
                            that.data('next', data.next)
                                .removeAttr('disabled')
                                .find('i')
                                .hide()
                        } else {
                            that.parent().remove()
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
