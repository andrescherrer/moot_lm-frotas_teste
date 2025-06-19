@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <div class="flex justify-between items-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 border border-primary-200 rounded-lg text-primary-300 cursor-default">
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="px-4 py-2 border border-primary-300 rounded-lg text-primary-600 hover:bg-primary-50 transition-colors">
                    Anterior
                </a>
            @endif

            {{-- Pagination Elements --}}
            <div class="hidden sm:flex gap-1">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="px-3 py-1 text-primary-400">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-3 py-1 bg-primary-600 text-white rounded-lg">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1 text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="px-4 py-2 border border-primary-300 rounded-lg text-primary-600 hover:bg-primary-50 transition-colors">
                    Próxima
                </a>
            @else
                <span class="px-4 py-2 border border-primary-200 rounded-lg text-primary-300 cursor-default">
                    Próxima
                </span>
            @endif
        </div>
    </nav>
@endif