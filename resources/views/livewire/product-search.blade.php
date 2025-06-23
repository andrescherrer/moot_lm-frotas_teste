<div>
    <div class="mb-8 p-6 bg-white rounded-xl shadow-lg border border-primary-100">
        <h2 class="text-xl font-semibold text-dark-800 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Filtros de Busca
        </h2>
        
        <div class="flex flex-col md:flex-row gap-4 items-start">
            <div class="w-full md:w-1/3">
                <label class="block text-sm font-medium text-dark-700 mb-1">Nome do Produto</label>
                <input 
                    type="text" 
                    wire:model.live="searchName" 
                    placeholder="Digite para buscar..." 
                    class="w-full px-4 py-2 border border-primary-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 placeholder-primary-300"
                >
                <button 
                    wire:click="resetFilters" 
                    class="px-4 py-2 mt-5 bg-gradient-to-br from-primary-400 to-primary-600 hover:from-primary-500 hover:to-primary-700 text-white rounded-lg transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                    Limpar Filtros
                </button>
            </div>

            <div class="w-full md:w-1/3">
                <label class="block text-sm font-medium text-dark-700 mb-1">Categorias</label>
                <select 
                    wire:model.live="selectedCategories" 
                    multiple
                    class="w-full px-2 py-1 border border-primary-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 min-h-[42px] text-dark-800"
                >
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" class="hover:bg-primary-50">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-1/3">
                <label class="block text-sm font-medium text-dark-700 mb-1">Marcas</label>
                <select 
                    wire:model.live="selectedBrands" 
                    multiple
                    class="w-full px-2 py-1 border border-primary-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 min-h-[42px] text-dark-800"
                >
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" class="hover:bg-primary-50">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>                    
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-primary-100 overflow-hidden">
        <div class="grid grid-cols-12 bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4 text-white font-medium">
            <div class="col-span-4">Produto</div>
            <div class="col-span-4">Marca</div>
            <div class="col-span-4">Categorias</div>
        </div>

        @if($products->isEmpty())
            <div class="p-8 text-center text-dark-500 bg-primary-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-4 text-lg font-medium text-dark-700">Nenhum produto encontrado</p>
                <p class="text-dark-500">Tente ajustar seus filtros de busca</p>
            </div>
        @else
            @foreach($products as $product)
                <div class="grid grid-cols-12 px-6 py-4 border-b border-primary-100 hover:bg-primary-50 transition-colors duration-150 even:bg-primary-50/30">
                    
                    <div class="col-span-4 flex items-center">
                        <div class="font-medium text-dark-800">{{ $product->name }}</div>
                    </div>

                    <div class="col-span-4 flex items-center">
                        <span class="px-3 py-1 bg-primary-100 text-primary-800 text-sm rounded-full font-medium">
                            {{ $product->brand->name }}
                        </span>
                    </div>

                    <div class="col-span-4 flex flex-wrap gap-2 items-center">
                        @foreach($product->categories as $category)
                            <span class="px-1 py-1 bg-secondary-100 text-secondary-800 text-xs rounded-full font-medium">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif

        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-primary-200 bg-primary-50">
                {{ $products->links('livewire::custom-pagination') }}
            </div>
        @endif
    </div>
</div>