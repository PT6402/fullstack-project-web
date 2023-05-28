<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ColorSize;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->join('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
        ->select('products.id', 'products.product_name', 'products.product_slug', 'products.product_price', 'products.product_description', 'products.product_type', 'products.product_material', 'categories.category_name',  'subcategories.subcategory_name', )
        ->get();

        foreach ($products as $product) {
            $colorSizes = ColorSize::join('colors', 'color_sizes.color_id', '=', 'colors.id')
                ->join('sizes', 'color_sizes.size_id', '=', 'sizes.id')
                ->select('colors.color_name', 'sizes.size_name','color_sizes.quantity' )
                ->where('color_sizes.product_id', $product->id)
                ->get()
                ->map(function ($item) {
                    return collect($item)->except('product_id')->all();
                });

            $product->colorSizes = $colorSizes;
        }



        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }




}
