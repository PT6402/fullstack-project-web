<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    //
    public function index()
    {
        $subcategories = Subcategory::select('subcategory_name', 'subcategory_slug', 'category_id','image')
            ->get();

        $categoryIds = $subcategories->pluck('category_id')->unique();

        $categories = Category::whereIn('id', $categoryIds)
            ->select('id', 'category_name')
            ->get();

        $subcategoriesWithCategory = $subcategories->map(function ($subcategory) use ($categories) {
            $category = $categories->firstWhere('id', $subcategory->category_id);
            $subcategory->category_name = $category->category_name;
            return $subcategory;
        });

        return response()->json([
            'status' => 200,
            'subcategories' => $subcategoriesWithCategory,
        ]);
    }




}
