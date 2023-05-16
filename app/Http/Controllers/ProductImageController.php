<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductImageController extends Controller
{
    //
    public function imageStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }

        $product_id = $request->id;
        $images = $request->file('images');

        // Store images and create image records in the database
        foreach ($images as $key => $image) {
            $imageName = $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);

            $productImage = new ProductImage;
            $productImage->product_id = $product_id;
            $productImage->url =  'storage/images/'. $imageName;
            $productImage->is_main = ($key === 0); // Set the first image as main image by default
            $productImage->save();
        }

        // Update main image if user selects a different image
        if ($request->has('main_image_id')) {
            $main_image_id = $request->input('main_image_id');
            $main_image = ProductImage::where('id', $main_image_id)
                ->where('product_id', $product_id)
                ->first();

            if ($main_image) {
                ProductImage::where('product_id', $product_id)
                    ->update(['is_main' => false]);

                $main_image->is_main = true;
                $main_image->save();
            }
        }

        return response()->json(['message' => 'Images uploaded successfully.','images'=>$productImage]);
    }
    public function updateImage(Request $request)
{
    $validator = Validator::make($request->all(), [
        'main_image_id' => 'required|exists:product_images,id',
        'product_id' => 'required|exists:products,id',
    ]);

    // Handle validation errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->messages()], 422);
    }

    $product_id = $request->input('product_id');
    $main_image_id = $request->input('main_image_id');

    $main_image = ProductImage::where('id', $main_image_id)
        ->where('product_id', $product_id)
        ->first();

    if ($main_image) {
        ProductImage::where('product_id', $product_id)
            ->update(['is_main' => false]);

        $main_image->is_main = true;
        $main_image->save();

        return response()->json(['message' => 'Main image updated successfully.']);
    }

    return response()->json(['errors' => 'Main image not found.'], 404);
}
public function indexImages($id)
{
    // Find product by id
    $product = Product::find($id);

    // Return error response if product not found
    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    // Get all images for product
    $images = $product->productImages;

    // Return response with images
    return response()->json(['images' => $images], 200);
}


}
