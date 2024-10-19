
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex justify-center items-center space-x-4"> <!-- Căn giữa bằng justify-center -->
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="disabled" aria-disabled="true">&laquo; Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="text-blue-600 hover:underline">&laquo; Previous</a>
        @endif

        {{-- Pagination Elements --}}
        <div class="flex items-center space-x-2"> <!-- Giữ khoảng cách giữa các số trang -->
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span>{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="font-bold text-blue-600">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="text-blue-600 hover:underline">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="text-blue-600 hover:underline">Next &raquo;</a>
        @else
            <span class="disabled" aria-disabled="true">Next &raquo;</span>
        @endif
    </nav>
@endif


