@if ($paginator->hasPages())
    <ul class="pagination pagination-primary-soft d-inline-block d-md-flex rounded mb-0" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled mb-0" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>
            </li>
        @else
            <li class="page-item mb-0">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fas fa-angle-double-left"></i></a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled mb-0" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active mb-0" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item mb-0"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item mb-0">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fas fa-angle-double-right"></i></a>
            </li>
        @else
            <li class="page-item disabled mb-0" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>
            </li>
        @endif
    </ul>
@endif
