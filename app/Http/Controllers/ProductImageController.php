<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductImageController extends Controller
{
    //
    // public function imageStore(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    //     ]);

    //     // Handle validation errors
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->messages()], 422);
    //     }

    //     $product_id = $request->id;
    //     $images = $request->file('images');

    //     // Store images and create image records in the database
    //     foreach ($images as $key => $image) {
    //         $imageName = $image->getClientOriginalName();
    //         $image->storeAs('public/images', $imageName);

    //         $productImage = new ProductImage;
    //         $productImage->product_id = $product_id;
    //         $productImage->url =  $image->storeAs('/storage/images', $imageName);


    //         $productImage->is_main = ($key === 0); // Set the first image as main image by default
    //         $productImage->save();
    //     }

    //     // Update main image if user selects a different image
    //     if ($request->has('main_image_id')) {
    //         $main_image_id = $request->input('main_image_id');
    //         $main_image = ProductImage::where('id', $main_image_id)
    //             ->where('product_id', $product_id)
    //             ->first();

    //         if ($main_image) {
    //             ProductImage::where('product_id', $product_id)
    //                 ->update(['is_main' => false]);

    //             $main_image->is_main = true;
    //             $main_image->save();
    //         }
    //     }

    //     return response()->json(['message' => 'Images uploaded successfully.','images'=>$productImage]);
    // }


    public function imageStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $images = $request->file('images');

        foreach ($images as $image) {
            // Tạo tên mới cho hình ảnh
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Di chuyển hình ảnh vào thư mục public/images
            $image->move(public_path('images'), $imageName);

            // Lưu thông tin hình ảnh vào bảng product_images
            $productImage = new ProductImage;
            $productImage->product_id = $request->id; // ID của sản phẩm liên quan
            $productImage->url = 'images/' . $imageName;
            $productImage->save();
        }


        return response()->json(['message' => 'Upload successful', 'images_path' => '/images/' . $imageName], 200);


        // return response()->json(['message' => 'No images selected'], 400);
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
        $images = $product->images()->select("url", "id", "is_main")->get();
        if (empty($images)) {
            return response()->json(['images' => null], 200);
        }
        // Return response with images
        return response()->json(['images' => $images], 200);
    }


    public function Is_Main(Request $request)
    {
        $productId = $request->id_product;
    $imageId = $request->id_image;

    // Đảm bảo chỉ có một hình ảnh là is_main = 1
    ProductImage::where('product_id', $productId)->update(['is_main' => 0]);

    $productImage = ProductImage::where('product_id', $productId)->find($imageId);

    if (!$productImage) {
        return response()->json(["message" => "Image not found"]);
    }

    $productImage->is_main = 1;
    $productImage->save();

    return response()->json(["message" => "Image set as main successfully"]);
    }
    public function deleteImage($id)
{
    $image = ProductImage::find($id);

    if (!$image) {
        return response()->json(['message' => 'Image not found'], 404);
    }

    if ($image->is_main == 1) {
        return response()->json(['message' => 'Cannot delete main image. Please change the main image first.'], 400);
    }

    // Xóa hình ảnh từ thư mục lưu trữ (public/images)
    $imagePath = public_path($image->url);
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Xóa hình ảnh trong cơ sở dữ liệu
    $image->delete();

    return response()->json(['message' => 'Image deleted successfully'], 200);
}

}
