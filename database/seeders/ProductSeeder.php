<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = Brand::all();
        $categories = Category::all();

        $products = [
            [
                'name' => 'Tênis Air Max',
                'brand_id' => $brands->where('name', 'Nike')->first()->id,
                'categories' => ['Calçados', 'Esportes']
            ],
            [
                'name' => 'Camiseta Dry-Fit',
                'brand_id' => $brands->where('name', 'Adidas')->first()->id,
                'categories' => ['Roupas', 'Esportes']
            ],
            [
                'name' => 'iPhone 15',
                'brand_id' => $brands->where('name', 'Apple')->first()->id,
                'categories' => ['Eletrônicos']
            ],
            [
                'name' => 'Galaxy S23',
                'brand_id' => $brands->where('name', 'Samsung')->first()->id,
                'categories' => ['Eletrônicos', 'Acessórios']
            ],
            [
                'name' => 'Fone WH-1000XM5',
                'brand_id' => $brands->where('name', 'Sony')->first()->id,
                'categories' => ['Eletrônicos', 'Acessórios']
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'brand_id' => $productData['brand_id']
            ]);

            $categoryIds = $categories->whereIn('name', $productData['categories'])
                                ->pluck('id')
                                ->toArray();
            
            $product->categories()->attach($categoryIds);
        }
    }
}
