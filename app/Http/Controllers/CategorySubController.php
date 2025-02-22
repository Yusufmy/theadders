<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorySubRequest;
use App\Interfaces\ProductCategoryInterface;
use App\Models\CategorySub;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategorySubController extends Controller
{
    private ProductCategoryInterface $productCategoryRepository;

    public function __construct(ProductCategoryInterface $userRepositoryInterface)
    {
        $this->productCategoryRepository = $userRepositoryInterface;
    }

    public function storeSubCategory(CategorySubRequest $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validated();

            $subCategory = $this->productCategoryRepository->storeSubCategory($validatedData);
            DB::commit();
            return response()->json($subCategory, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
