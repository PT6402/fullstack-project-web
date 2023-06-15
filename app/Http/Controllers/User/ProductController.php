<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ColorSize;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->select('products.id', 'products.product_name', 'products.product_slug', 'products.product_price', 'products.product_description', 'products.product_type', 'products.product_status', 'products.product_material', 'categories.category_name', 'subcategories.subcategory_name')
            ->get();

        foreach ($products as $product) {
            $colorSizes = ColorSize::join('colors', 'color_sizes.color_id', '=', 'colors.id')
                ->join('sizes', 'color_sizes.size_id', '=', 'sizes.id')
                ->select('colors.color_name', 'color_sizes.color_id', 'sizes.size_name', 'color_sizes.size_id', 'color_sizes.quantity')
                ->where('color_sizes.product_id', $product->id)
                ->get()
                ->groupBy('color_name')
                ->map(function ($items, $colorName) use ($product) {
                    $sizes = $items->map(function ($item) use ($product, $colorName) {
                        $sizeId = $product->category_id . $product->product_name . $colorName . $item->size_name . $item->color_id;
                        return [
                            'id' => $sizeId,
                            'size_name' => $item->size_name,
                            'quantity' => $item->quantity,
                        ];
                    })->all();

                    $images = ProductImage::join('colors', 'product_images.color_id', '=', 'colors.id')
                        ->where('product_images.product_id', $product->id)
                        ->where('colors.color_name', $colorName)
                        ->select('product_images.url', 'product_images.id', 'product_images.is_main')
                        ->get()
                        ->map(function ($item) {
                            return [
                                'url' => $item->url,
                                'id' => $item->id,
                                'is_main' => $item->is_main,
                            ];
                        });

                    $categoryName = strtolower(str_replace(' ', '-', $product->category_name));
                    $productName = strtolower(str_replace(' ', '-', $product->product_name));
                    $colorName = strtolower(str_replace(' ', '-', $colorName));
                    $url = $categoryName . '-' . $productName . '-' . $colorName;

                    $colorSizeId = $product->id . '000' . $items[0]->color_id;

                    return [
                        'id' => $colorSizeId,
                        'color_name' => $colorName,
                        'sizes' => $sizes,
                        'images' => $images,
                        'url' => $url,
                    ];
                })
                ->values();

            $product->colorSizes = $colorSizes;
            $product->reviews;
            $product->rating = $product->calculateAverageRatingForProducts();
            // Tạo mảng product_url chứa các URL cho mỗi color
            $product->product_url = $colorSizes->pluck('url')->toArray();
        }

        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }
    public function show($productSlug)
    {
        $product = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->select('products.id', 'products.product_name', 'products.product_slug', 'products.product_price', 'products.product_description', 'products.product_type', 'products.product_status', 'products.product_material', 'categories.category_name', 'subcategories.subcategory_name')
            ->where('products.product_slug', $productSlug)
            ->firstOrFail();

        $colorSizes = ColorSize::join('colors', 'color_sizes.color_id', '=', 'colors.id')
            ->join('sizes', 'color_sizes.size_id', '=', 'sizes.id')
            ->select('colors.color_name', 'color_sizes.color_id', 'sizes.size_name', 'color_sizes.size_id', 'color_sizes.quantity')
            ->where('color_sizes.product_id', $product->id)
            ->get()
            ->groupBy('color_name')
            ->map(function ($items, $colorName) use ($product) {
                $sizes = $items->map(function ($item) use ($product, $colorName) {
                    $sizeId = $product->category_id . $product->product_name . $colorName . $item->size_name . $item->color_id;
                    return [
                        'id' => $sizeId,
                        'size_name' => $item->size_name,
                        'quantity' => $item->quantity,
                    ];
                })->all();

                $images = ProductImage::join('colors', 'product_images.color_id', '=', 'colors.id')
                    ->where('product_images.product_id', $product->id)
                    ->where('colors.color_name', $colorName)
                    ->select('product_images.url', 'product_images.id', 'product_images.is_main')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'url' => $item->url,
                            'id' => $item->id,
                            'is_main' => $item->is_main,
                        ];
                    });

                $categoryName = strtolower(str_replace(' ', '-', $product->category_name));
                $productName = strtolower(str_replace(' ', '-', $product->product_name));
                $colorName = strtolower(str_replace(' ', '-', $colorName));
                $url = $categoryName . '-' . $productName . '-' . $colorName;

                $colorSizeId = $product->id . '000' . $items[0]->color_id;

                return [
                    'id' => $colorSizeId,
                    'color_name' => $colorName,
                    'sizes' => $sizes,
                    'images' => $images,
                    'url' => $url,
                ];
            })
            ->values();

        $product->colorSizes = $colorSizes;

        $product->review = $product->reviews->where("status", 1)->load('user');
        unset($product->reviews);
        $product->rating = $product->calculateAverageRatingForProducts();
        return response()->json([
            'status' => 200,
            'products' => $product,
        ]);
    }

    // public function calculateAverageRatingForProducts($product_id)
    // {
    //     // Lấy danh sách tất cả sản phẩm
    //     $products = Product::where("id",$product_id)->get();

    //     foreach ($products as $product) {
    //         // Lấy tất cả các đánh giá (ratings) của sản phẩm
    //         $ratings = $product->reviews;

    //         // Tính tổng các giá trị rating
    //         $totalRating = 0;
    //         foreach ($ratings as $rating) {
    //             $totalRating += $rating->rate;
    //         }

    //         // Tính lượt rate trung bình
    //         $averageRating = count($ratings) > 0 ? $totalRating / count($ratings) : 0;

    //         // Lưu lượt rate trung bình vào sản phẩm
    //        $averageRating;

    //        return response()->json(['averageRating' =>  $averageRating]);
    //     }
    // }
}
