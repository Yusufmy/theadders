<?php

namespace App\Repositories;

use App\Interfaces\ProductCategoryInterface;
use App\Models\Categories;
use App\Models\Product;
use App\Models\CategorySub;

class ProductCategoryRepository implements ProductCategoryInterface
{
    public function storeProduct($product)
    {
        // Implementasi untuk menyimpan produk
        try {
            return $product = Product::create([
                'category_id' => $product['category_id'],
                'category_sub_id' => $product['category_sub_id'],
                'product_name' => $product['product_name'],
                'description' => $product['description'],
                'thumbail' => $product['thumbail'],
                'price' => $product['price'],
                'start_price' => $product['start_price'],
                'end_price' => $product['end_price'],
                'year_release' => $product['year_release'],
                'buy_release' => $product['buy_release'],
                'item_codition' => $product['item_codition'],
                'view_count' => $product['view_count'],
                'author' => 'system',
                'status' => $product['status'],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to store product: ' . $e->getMessage()], 500);
        }
    }

    public function storeCategory($category)
    {
        // Implementasi untuk menyimpan kategori
        try {
            $category = Categories::create([
                'category_name' => $category['category_name'],
                'icon' => $category['icon'],
                'author' => 'system',
                'status' => $category['status'],
            ]);

            return $category;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to store category: ' . $e->getMessage()], 500);
        }
    }

    public function storeSubCategory($subCategory)
    {
        try {
            $subCategory = CategorySub::create([
                'category_id' => $subCategory['category_id'],
                'category_name' => $subCategory['category_name'],
                'icon' => $subCategory['icon'],
                'author' => 'system',
                'status' => $subCategory['status'],
            ]);

            return $subCategory;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to store sub-category: ' . $e->getMessage()], 500);
        }
    }

    public function getProducts(array $filters)
    {
        $query = Product::with(['category', 'categorySub'])
            ->filter([
                'category_id' => $filters['category_id'] ?? null,
                'category_sub_id' => $filters['category_sub_id'] ?? null,
                'search' => $filters['search'] ?? null,
                'sort' => $filters['sort'] ?? null,
                'size' => $filters['size'] ?? null,
                'price_range' => $filters['price_range'] ?? null,
            ]);

        if (isset($filters['per_page'])) {
            return $query->paginate($filters['per_page']);
        }

        return $query->get();
    }
}
