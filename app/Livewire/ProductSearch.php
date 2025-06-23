<?php

namespace App\Livewire;


use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;


class ProductSearch extends Component
{
    use WithPagination;

    use WithPagination;
    
    #[Url(keep: true)]
    public $searchName = '';
    
    #[Url(keep: true)]
    public $selectedCategories = [];
    
    #[Url(keep: true)]
    public $selectedBrands = [];

    public $page = 1;

    protected $queryString = [
        'searchName' => ['except' => '', 'as' => 'q'],
        'selectedCategories' => ['except' => [], 'as' => 'categories'],
        'selectedBrands' => ['except' => [], 'as' => 'brands'],
    ];

    protected $paginationTheme = 'custom-pagination'; 

    public function render()
    {
        $products = Product::query()
            ->when($this->searchName, function ($query) {
                if (config('database.default') === 'sqlite') {
                    $query->where('name', 'like', '%' . strtolower($this->searchName) . '%');
                } else {
                    $query->where('name', 'ilike', '%' . $this->searchName . '%');
                }
            })
            ->when($this->selectedBrands, function ($query) {
                $query->whereIn('brand_id', $this->selectedBrands);
            })
            ->when($this->selectedCategories, function ($query) {
                $query->whereHas('categories', function ($q) {
                    $q->whereIn('id', $this->selectedCategories);
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

    public function updatingSearchName($value)
    {
        $this->resetPage();
    }
    
    public function updatingSelectedCategories($value)
    {
        $this->resetPage();
    }
    
    public function updatingSelectedBrands($value)
    {
        $this->resetPage();
    }
}
