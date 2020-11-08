<div class="list-pagination">
    Showing
        {{ $paginator->firstItem() }} -
        {{ $paginator->lastItem() }} of
        {{ $paginator->total() }}

    <ul class="pagination pagination-lg">

        <li class="first"><a href="#">First</a></li>

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="prev disabled"><a href="#">Previous</a></li>
        @else
            <li class="prev"><a href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
        @endif

        {{-- inside links --}}
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)

            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                {{-- <li class="page disabled"><span>{{ $element }}</span></li> --}}
                <li class="page disabled"><span><a href="#">{{ $element }}</a></span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page active"><a href="#" title="Current page">{{ $page }}</a></li>
                    @else
                        <li class="page"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif

        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="next"><a href="{{ $paginator->nextPageUrl() }}">Next</a></li>
        @else
            <li class="next disabled"><a href="#">Next</a></li>
        @endif



        <li class="last disabled"><a href="#">Last</a></li>
    </ul>
</div>
