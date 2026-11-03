@if ($paginator->hasPages())
    <nav class="adm-pager" role="navigation" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="is-disabled"><i class="fa-solid fa-chevron-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa-solid fa-chevron-left"></i></a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="is-gap">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="is-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa-solid fa-chevron-right"></i></a>
        @else
            <span class="is-disabled"><i class="fa-solid fa-chevron-right"></i></span>
        @endif
    </nav>
@endif
