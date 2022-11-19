@if ($paginator->hasPages())
    <nav class="wt-pagination wt-savepagination">
        <ul>
            {{-- Previous Page Link --}}
            <li class="wt-prevpage">
                <a href="@if ($paginator->onFirstPage())javascript:void(0);@else{{ $paginator->previousPageUrl() }}@endif">
                    <i class="lnr lnr-chevron-left"></i>
                </a>
            </li>

            {{-- Next Page Link --}}
            <li class="wt-nextpage">
                <a href="@if (!$paginator->hasMorePages())javascript:void(0);@else{{ $paginator->nextPageUrl() }}@endif">
                    <i class="lnr lnr-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
@endif
