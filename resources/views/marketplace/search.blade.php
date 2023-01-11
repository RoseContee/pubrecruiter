@extends('marketplace.partials.layout')

@php
    $contact_type = auth()->user()->type == 'Creator' ? 'brands' : 'creators';
    $brands = $contact_type == 'brands';
@endphp
@section('title', 'Find '.ucfirst($contact_type))

@section('header-menu')
    @php
        $keyword = $keyword ?? '';
        $c = $c ?? '';
        $n = $n ?? '';
    @endphp
    <ul class="navbar-nav ml-0 mr-lg-auto ml-lg-5 d-block d-lg-flex mt-3 mt-lg-0">
        <!-- Navbar Search -->
        <li class="nav-item">
            <form name="searchContact" action="{{ route($contact_type) }}" class="search-bar" method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control form-control-navbar"
                           value="{{ $keyword }}" placeholder="I'm looking for" aria-label="I'm looking for">
                    <div class="input-group-append">
                        @if ($brands)
                            <a href="javascript:void(0);" id="searchBrand"
                               class="btn btn-navbar btn-main d-flex align-items-center">
                                <i class="fas fa-search"></i>
                            </a>
                        @else
                            <button type="submit" class="btn btn-navbar btn-main">
                                <i class="fas fa-search"></i>
                            </button>
                        @endif
                    </div>
                </div>
                @if ($brands)
                    <div class="d-block d-sm-flex filter-options position-absolute mt-1">
                        <div class="form-inline align-items-center mb-1 mb-sm-0">
                            <input type="hidden" name="c" value="{{ $c }}">
                            <label for="commission-sort" class="mr-3 mr-sm-2 mb-0">Sort By:</label>
                            <a href="javascript:void(0);" id="commission-sort" class="btn btn-main btn-sm">
                                Commission
                                @if ($c == 'asc')
                                    <i class="fa fa-sort-amount-up ml-1"></i>
                                @elseif ($c == 'desc')
                                    <i class="fa fa-sort-amount-down ml-1"></i>
                                @else
                                    <i class="fa fa-sort ml-1"></i>
                                @endif
                            </a>
                        </div>
                        <div class="form-inline align-items-center ml-0 ml-sm-3">
                            <label for="network-filter" class="mr-2 mb-0">Filter By:</label>
                            <select id="network-filter" name="n" class="form-control">
                                <option value="">Select Network</option>
                                @foreach ($networks as $network)
                                    <option value="{{ $network }}" @if (!strcasecmp($network, $n)) selected @endif>
                                        {{ $network }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
            </form>
        </li>
    </ul>

    <ul class="navbar-nav align-items-center justify-content-end ml-lg-auto right-menu">
        @include('marketplace.partials.notifications.area')

        <li class="nav-item mini-menu">
            <a href="javascript:void(0);" class="nav-link text-gray">
                <i class="fa fa-bars fa-2x"></i>
            </a>
            <ul class="navbar-nav justify-content-center">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="btn btn-main ml-xl-3">
                        My Account
                    </a>
                </li>

                @if (request()->route()->getName() == 'home')
                    <li class="nav-item">
                        <a href="{{ route($contact_type) }}" class="btn btn-main ml-3">
                            {{ ucfirst(trim($contact_type, 's')) }} Marketplace
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    </ul>
@endsection

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

@section('footer')
    @include('marketplace.partials.footer')
@endsection

@push('script')
    <script type="text/javascript">
    @if ($brands)
        let c = '{{ $c == 'asc' ? 'asc' : ($c == 'desc' ? 'desc' : '') }}'
        $(function() {
            $(document).on('click', '#searchBrand', function() {
                searchBrand()
            }).on('click', '#commission-sort', function() {
                if (c == 'desc') c = 'asc'
                else if (c == 'asc') c = ''
                else c = 'desc'
                $('[name="c"]').val(c)
                searchBrand()
            }).on('change', function() {
                searchBrand()
            })
        })

        function searchBrand() {
            document.searchContact.submit()
        }
    @endif
    </script>

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
