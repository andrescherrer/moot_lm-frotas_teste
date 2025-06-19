@if ($paginator->hasPages())
    <nav role="navigation">
        <div class="flex justify-between">
            {{-- Botão Anterior --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-gray-400">&laquo; Anterior</span>
            @else
                <button 
                    wire:click="previousPage"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 text-primary-600 hover:text-primary-800"
                >
                    &laquo; Anterior
                </button>
            @endif

            {{-- Páginas --}}
            <div class="hidden sm:flex">
                @foreach ($elements as $element)
                    {{-- "Três pontos" --}}
                    @if (is_string($element))
                        <span class="px-4 py-2">{{ $element }}</span>
                    @endif

                    {{-- Array de páginas --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-4 py-2 bg-primary-600 text-white rounded">{{ $page }}</span>
                            @else
                                <button 
                                    wire:click="gotoPage({{ $page }})"
                                    class="px-4 py-2 text-primary-600 hover:text-primary-800"
                                >
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Próxima --}}
            @if ($paginator->hasMorePages())
                <button 
                    wire:click="nextPage"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 text-primary-600 hover:text-primary-800"
                >
                    Próxima &raquo;
                </button>
            @else
                <span class="px-4 py-2 text-gray-400">Próxima &raquo;</span>
            @endif
        </div>
    </nav>
@endif