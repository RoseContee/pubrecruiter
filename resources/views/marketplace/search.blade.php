@extends('marketplace.homepage-layout')

@php
    $contact_type = auth()->user()->type == 'Creator' ? 'brands' : 'creators';
    $brands = $contact_type == 'brands';
@endphp
@section('title', 'Find '.ucfirst($contact_type))

@section('content')
    <!--Main Start-->
    <main class="container pt-5 my-5">
        <div id="contacts-list" class="row">
            @forelse ($contacts as $contact)
                @include('marketplace.partials.contact.item')
            @empty
                <div class="col-12 text-center py-5">
                    <h4 class="my-5 py-3 font-weight-normal">Not {{ ucfirst($contact_type) }} Found</h4>
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
    </main>
    <!--Main End-->
@endsection

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
