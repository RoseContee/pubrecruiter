@if ($paginator->hasPages())
    <nav class="wt-pagination wt-savepagination">
        <ul>
            {{-- Previous Page Link --}}
            <li class="wt-prevpage">
                <a href="@if ($paginator->onFirstPage())javascript:void(0);@else{{ $paginator->previousPageUrl() }}@endif">
                    <i class="lnr lnr-chevron-left"></i>
                </a>
            </li>

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))<li><a href="javascript:void(0);">...</a></li>@endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @php
                        $first = $paginator->currentPage() - 2;
                        if ($first < 1) $first = 1;
                        else if ($first + 4 > $paginator->lastPage()) $first = $paginator->lastPage() - 4;
                        $last = $first + 4;
                    @endphp
                    @foreach ($element as $page => $url)
                        @if ($page < $first || $page > $last) @continue @endif
                        @if ($page == $paginator->currentPage())
                            <li><a href="javascript:void(0);">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            <li class="wt-nextpage">
                <a href="@if (!$paginator->hasMorePages())javascript:void(0);@else{{ $paginator->nextPageUrl() }}@endif">
                    <i class="lnr lnr-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
@endif
