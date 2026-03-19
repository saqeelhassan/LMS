@if ($paginator->hasPages())
    <ul class="pagination pagination-primary-soft d-inline-block d-md-flex rounded mb-0" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled mb-0" aria-disabled="true">
                <span class="page-link">{!! __('pagination.previous') !!}</span>
            </li>
        @else
            <li class="page-item mb-0">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">{!! __('pagination.previous') !!}</a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item mb-0">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">{!! __('pagination.next') !!}</a>
            </li>
        @else
            <li class="page-item disabled mb-0" aria-disabled="true">
                <span class="page-link">{!! __('pagination.next') !!}</span>
            </li>
        @endif
    </ul>
@endif
