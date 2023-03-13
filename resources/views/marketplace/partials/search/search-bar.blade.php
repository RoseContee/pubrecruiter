@php
    $keyword = $keyword ?? '';
    $c = $c ?? '';
    $n = $n ?? '';
@endphp
<form name="searchContact" action="{{ $route }}" class="search-bar" method="GET">
    <div class="input-group">
        <input type="text" name="q" class="form-control form-control-navbar"
               value="{{ $keyword }}" placeholder="I'm looking for" aria-label="I'm looking for">
        <div class="input-group-append">
            @if (!$brand_user)
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
    @if (!$brand_user)
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


@push('script')
    <script type="text/javascript">
        @if (!$brand_user)
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
@endpush
