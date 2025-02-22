<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductIndexRequest;
use App\Interfaces\ProductCategoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private ProductCategoryInterface $productCategoryRepository;

    public function __construct(ProductCategoryInterface $userRepositoryInterface)
    {
        $this->productCategoryRepository = $userRepositoryInterface;
    }

    public function storeProduct(ProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $subCategory = $this->productCategoryRepository->storeProduct($validatedData);
            DB::commit();
            return response()->json($subCategory, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function index(ProductIndexRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            $products = $this->productCategoryRepository->getProducts($validatedData);
            return response()->json($products, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
