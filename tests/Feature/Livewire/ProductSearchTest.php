<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Livewire\ProductSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->brand1 = Brand::factory()->create(['name' => 'Brand A']);
        $this->brand2 = Brand::factory()->create(['name' => 'Brand B']);
        
        $this->category1 = Category::factory()->create(['name' => 'Eletrônicos']);
        $this->category2 = Category::factory()->create(['name' => 'Roupas']);
        
        $this->product1 = Product::factory()->create([
            'name' => 'Smartphone X',
            'brand_id' => $this->brand1->id,
        ]);
        $this->product1->categories()->attach($this->category1);
        
        $this->product2 = Product::factory()->create([
            'name' => 'Camiseta Premium',
            'brand_id' => $this->brand2->id,
        ]);
        $this->product2->categories()->attach($this->category2);
    }

    #[Test]
    public function renders_product_search_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);

        Livewire::actingAs($user)
            ->test(ProductSearch::class)
            ->assertStatus(200)
            ->assertSee('Smartphone X');
    }

    #[Test]
    public function displays_all_products_by_default()
    {
        Livewire::test(ProductSearch::class)
            ->assertSee('Smartphone X')
            ->assertSee('Camiseta Premium')
            ->assertViewHas('products', function($products) {
                return $products->count() === 2;
            });
    }

    #[Test]
    public function can_filter_products_by_name()
    {
        Livewire::test(ProductSearch::class)
            ->set('searchName', 'Smartphone')
            ->assertSee('Smartphone X')
            ->assertDontSee('Camiseta Premium');
    }

    #[Test]
    public function can_filter_products_by_brand()
    {
        Livewire::test(ProductSearch::class)
            ->set('selectedBrands', [$this->brand1->id])
            ->assertSee('Smartphone X')
            ->assertDontSee('Camiseta Premium');
    }

    #[Test]
    public function can_filter_products_by_category()
    {
        Livewire::test(ProductSearch::class)
            ->set('selectedCategories', [$this->category1->id])
            ->assertSee('Smartphone X')
            ->assertDontSee('Camiseta Premium');
    }

    #[Test]
    public function can_combine_multiple_filters()
    {
        Livewire::test(ProductSearch::class)
            ->set('searchName', 'Smartphone')
            ->set('selectedBrands', [$this->brand1->id])
            ->set('selectedCategories', [$this->category1->id])
            ->assertSee('Smartphone X')
            ->assertDontSee('Camiseta Premium');
    }

    #[Test]
    public function resets_filters_and_redirects()
    {
        Livewire::test(ProductSearch::class)
            ->set('searchName', 'Smartphone')
            ->set('selectedBrands', [$this->brand1->id])
            ->set('selectedCategories', [$this->category1->id])
            ->call('resetFilters')
            ->assertRedirect(route('dashboard'));
    }

    #[Test]
    public function resets_page_when_updating_search()
    {
        Product::factory()->count(15)->create();
        $testProduct = Product::first();
        
        $component = Livewire::withQueryParams(['page' => 2])
            ->test(ProductSearch::class);
        
        $this->assertEquals(2, $component->viewData('products')->currentPage());
        
        $component->set('searchName', $testProduct->name);
        
        $this->assertEquals(1, $component->viewData('products')->currentPage());
        
        $component->assertSee($testProduct->name);
    }


    #[Test]
    public function updates_query_string_parameters()
    {
        Livewire::test(ProductSearch::class)
            ->set('searchName', 'Smartphone')
            ->set('selectedBrands', [$this->brand1->id])
            ->set('selectedCategories', [$this->category1->id])
            ->assertSet('searchName', 'Smartphone')
            ->assertSet('selectedBrands', [$this->brand1->id])
            ->assertSet('selectedCategories', [$this->category1->id]);
    }
}