<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\ColorSize;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;

use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function showAll()
    {
        $colors = Color::all();
        $sizes = Size::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return response()->json([
            'colors' => $colors,
            'sizes' => $sizes,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }
    public function index()
    {
        $products = Product::all();
        $product = new Product;
        $columnNames = $product->getColumnNames();

        return response()->json([
            'status' => 200,
            'headerTable' =>  $columnNames,
            'bodyTable' => $products
        ]);
    }
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            // 'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'colors' => 'required|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'required|array',
            'sizes.*' => 'exists:sizes,id',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:0',


        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }

        // Create product
        $product = new Product();
        $product->product_name = $request->input('name');
        $product->product_description = $request->input('description');
        $product->product_price = $request->input('price');
        $product->product_slug = strtolower(str_replace(' ', '-', $request->input('name')));

        $subcategory = Subcategory::findOrFail($request->input('subcategory_id'));
        $category = $subcategory->category;
        $product->subcategory()->associate($subcategory);
        $product->category()->associate($category);
        $product->save();
        $subcategory = SubCategory::find($request->input('subcategory_id'));
        $subcategory->increment('product_count');
        // Attach colors and quantities to product
        $colors = $request->input('colors');
        $quantities = $request->input('quantity');
        $sizes = $request->input('sizes');

        // Attach colors and quantities to product
        foreach ($colors as $key => $color) {
            $size = $sizes[$key];
            $quantity = $quantities[$key];

            // Attach color, size and quantity to product
            $productColorSize = new ColorSize([
                'product_id' => $product->id,
                'color_id' => $color,
                'size_id' => $size,
                'quantity' => $quantity
            ]);
            $productColorSize->save();
        }
        // Return response
        return response()->json([
            'message' => 'Product created successfully',
            'product_id' => $product->id
        ], 201);
    }


    public function edit($id)
    {
        // Get the product by id
        $product = Product::find($id);

        // If the product doesn't exist, return 404 error
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $colorSizes = DB::table('color_sizes')
            ->join('colors', 'color_sizes.color_id', '=', 'colors.id')
            ->join('sizes', 'color_sizes.size_id', '=', 'sizes.id')
            ->select('colors.id as color', 'sizes.id as size', 'color_sizes.quantity')
            ->where('color_sizes.product_id', $id)
            ->get();
            // Find product by id




    // Get all images for product
    $images = $product->images;

    // Return response with images
    // return response()->json(['images' => $images], 200);
        // Return the product
        return response()->json(['product' => $product, 'status' => 200, 'colorSizes' => $colorSizes],);
    }

    public function update(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'colors' => 'required|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'required|array',
            'sizes.*' => 'exists:sizes,id',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:0',
            'product_id' => 'required|exists:products,id',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }

        // Find product by ID
        $id = $request->product_id;
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Update product
        $product->product_name = $request->input('name');
        $product->product_description = $request->input('description');
        $product->product_price = $request->input('price');
        $product->category_id = $request->input('category_id');
        // $product->subcategory_id = $request->input('subcategory_id');
        $product->product_slug = strtolower(str_replace(' ', '-', $request->input('name')));

        $oldSubcategory = $product->subcategory;

        // Nếu subcategory mới khác với subcategory hiện tại
        if ($request->subcategory_id != $oldSubcategory->id) {
            // Giảm product_count của subcategory hiện tại đi 1
            $oldSubcategory->product_count -= 1;
            $oldSubcategory->save();

            // Cập nhật sản phẩm với subcategory mới
            $newSubcategory = Subcategory::find($request->subcategory_id);
            $product->subcategory()->associate($newSubcategory);
            $product->save();

            // Tăng product_count của subcategory mới lên 1
            $newSubcategory->product_count += 1;
            $newSubcategory->save();
        } else {
            // Nếu subcategory mới giống với subcategory hiện tại
            $product->save();
        }

        // Update colors and quantities for product
        $colors = $request->input('colors');
        $quantities = $request->input('quantity');
        $sizes = $request->input('sizes');

        // Detach all existing color sizes for the product
        DB::table('color_sizes')->where('product_id', $product->id)->delete();

        // Attach updated colors and quantities to product
        foreach ($colors as $key => $color) {
            $size = $sizes[$key];
            $quantity = $quantities[$key];

            // Attach color, size and quantity to product
            $productColorSize = new ColorSize([
                'product_id' => $product->id,
                'color_id' => $color,
                'size_id' => $size,
                'quantity' => $quantity
            ]);
            $productColorSize->save();
        }

        // Update product count for subcategory
        $subcategoryId = $product->sub_category_id;
        $productCount = DB::table('products')->where('sub_category_id', $subcategoryId)->count();
        $subcategory = SubCategory::find($subcategoryId);
        $subcategory->product_count = $productCount;
        $subcategory->save();


        // Return response
        return response()->json([
            'message' => 'Product updated successfully',
            'product_id' => $product->id
        ], 200);
    }

    public function getColorSizes($id)
    {
        $colorSizes = DB::table('color_sizes')
            ->join('colors', 'color_sizes.color_id', '=', 'colors.id')
            ->join('sizes', 'color_sizes.size_id', '=', 'sizes.id')
            ->select('colors.id as color_id', 'sizes.id as size_id')
            ->where('color_sizes.product_id', $id)
            ->get();

        return $colorSizes;
    }


    public function allProduct()
    {
        $products = Product::all();
        return response()->json($products);
    }


}
