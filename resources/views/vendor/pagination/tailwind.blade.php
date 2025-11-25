@if ($paginator->hasPages())
    <nav class="flex justify-end text-xs md:text-sm mt-8" role="navigation" aria-label="Pagination Navigation">
        <ul class="flex items-center gap-2">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="px-4 py-2 bg-gray-200 text-gray-500 rounded-xl cursor-not-allowed select-none">
                    Prev
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-xl
                               hover:bg-blue-600 hover:text-white transition">
                        Prev
                    </a>
                </li>
            @endif

            {{-- Pagination Numbers --}}
            @foreach ($elements as $element)
                {{-- "Three dots" separator --}}
                @if (is_string($element))
                    <li class="px-3 py-2 text-gray-500">{{ $element }}</li>
                @endif

                {{-- Array of links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-4 py-2 bg-blue-600 text-white rounded-xl font-semibold shadow">
                                {{ $page }}
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                    class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-xl
                                           hover:bg-blue-600 hover:text-white transition">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-xl
                               hover:bg-blue-600 hover:text-white transition">
                        Next
                    </a>
                </li>
            @else
                <li class="px-4 py-2 bg-gray-200 text-gray-500 rounded-xl cursor-not-allowed select-none">
                    Next
                </li>
            @endif

        </ul>
    </nav>
@endif
