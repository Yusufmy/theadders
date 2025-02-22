<?php

namespace App\Interfaces;

interface ProductCategoryInterface
{
    public function storeProduct(array $data);
    public function getProducts(array $filters);
    public function storeCategory(array $data);
    public function storeSubCategory(array $data);
}
