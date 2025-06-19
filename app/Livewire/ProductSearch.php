<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductSearch extends Component
{
    use WithPagination;

    public $searchName = '';
    public $selectedCategories = [];
    public $selectedBrands = [];

    protected $queryString = [
        'searchName' => ['except' => '', 'as' => 'q'],
        'selectedCategories' => ['except' => []],
        'selectedBrands' => ['except' => []],
    ];

    protected $paginationTheme = 'custom-pagination'; 

    public function render()
    {
        $products = Product::query()
            ->when($this->searchName, function ($query) {
                $query->where('name', 'ilike', '%' . $this->searchName . '%');
            })
            ->when($this->selectedBrands, function ($query) {
                $query->whereIn('brand_id', $this->selectedBrands);
            })
            ->when($this->selectedCategories, function ($query) {
                $query->whereHas('categories', function ($q) {
                    $q->whereIn('categories.id', $this->selectedCategories);
                });
            })
            ->with(['brand', 'categories'])
            ->orderBy('name')
            ->paginate(10);

        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('livewire.product-search', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['searchName', 'selectedCategories', 'selectedBrands']);

        return redirect()->route('dashboard');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingSelectedCategories()
    {
        $this->resetPage();
    }
    
    public function updatingSelectedBrands()
    {
        $this->resetPage();
    }
}
