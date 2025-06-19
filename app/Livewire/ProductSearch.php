<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductSearch extends Component
{
    public $search = '';
    public $selectedCategories = [];
    public $selectedBrands = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategories' => ['except' => []],
        'selectedBrands' => ['except' => []],
    ];

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'ilike', '%' . $this->search . '%');
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
        $this->reset(['search', 'selectedCategories', 'selectedBrands']);
    }
}
