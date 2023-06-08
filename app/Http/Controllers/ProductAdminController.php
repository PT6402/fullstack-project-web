<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Color;
use App\Models\Size;
use App\Models\ColorSize;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductAdminController extends Controller
{
    public function index(){
        $id = Session::get('admin_id');
        $admin = User::find($id);

        $products = Product::all();
        return view('product.index', compact('products'));
    }
    public function edit_product(Request $request ,$product_id){
        $id = Session::get('admin_id');
        $admin = User::find($id);
        $edit_product = Product::where('id',$product_id)->get();
        $cate_product = Category::orderby('id','desc')->get();
        $subcate_product = Subcategory::orderby('id','desc')->get();
        $colorsize_product = ColorSize::where('product_id',$product_id)->first();
        $color_product = Color::orderby('id','desc')->get();
        $size_product = Size::orderby('id','desc')->get();


        return view('product.update', compact('edit_product','cate_product','admin','subcate_product','color_product','size_product','colorsize_product'));
    }
    // public function postEdit(Request $request ,$product_id){
    //     $id = Session::get('admin_id');
    //     $admin = User::find($id);
    //     $edit_product = Product::where('id',$product_id)->get();
    //     $cate_product = Category::orderby('id','desc')->get();
    //     $subcate_product = Subcategory::orderby('id','desc')->get();
    //     $colorsize_product = ColorSize::where('product_id',$product_id)->first();
    //     $color_product = Color::orderby('id','desc')->get();
    //     $size_product = Size::orderby('id','desc')->get();


    //     return view('product.index', compact('edit_product','cate_product','admin','subcate_product','color_product','size_product','colorsize_product'));
    // }

    public function update_product(Request $request,$product_id){
        $data =$request->all();
        // dd( $data);
        $product = Product::find($product_id);

        $id = Session::get('admin_id');
        $admin = User::find($id);
        $productImages = [];
        if ($request->hasFile('product_image')) {
            $image = ProductImage::where('product_id',$product_id);
            $image->delete();
            foreach ($request->file('product_image') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('fontend/Image'), $imageName);
                    $productImages[] = $imageName;
                }
            }
        }
        foreach ($productImages as $imageName) {

            // $image = new ProductImage();
            // $image->product_id = $product->id;
            // $image->path = $imageName;
            // $image->save();

            $image = new ProductImage();
            $image->product_id = $product->id;
            $image->url = $imageName;
            $image->save();
        }

                    $product->product_name = $data['product_name'];
                    $product->product_description =   $data['product_description'];
                    $product->product_type =   $data['product_type'];
                    $product->product_material =   $data['product_material'];
                    $product->product_price =   $data['product_price'];


                    $product->category_id  =$data['category_id'];
                    $product->subcategory_id  =$data['subcategory_id'];
                    $product->product_status =$data['product_status'];

                $product->save();
                $colorsize = ColorSize::where('product_id', $product_id)->first();
                if ($colorsize) {
                    $colorsize->color_id  = $data['color_id'];
                    $colorsize->size_id  = $data['size_id'];
                    $colorsize->quantity  = $data['product_quantity'];
                $colorsize->save();
                }


        return redirect('product/index')->with('message', 'Updated Successfully');
    }

    public function delete_product($product_id){
    $id = Session::get('admin_id');
        $admin = User::find($id);

        DB::table('products')->where('id',$product_id)->delete();
        return redirect('product/index')->with('message', 'Deleted Successfully');
    }

    public function add_product_index(){
        $id = Session::get('admin_id');
        $admin = User::find($id);
        $cate_product = Category::all();
        $subcate_product = Subcategory::all();
        $color_product = Color::all();
        $size_product = Size::all();
        return view('product.create', compact('subcate_product','color_product','size_product','cate_product','admin'));
    }
    public function add_product(Request $request){
       $data = $request->all();
    //    dd($data);
        $id = Session::get('admin_id');
        $admin = User::find($id);
        $product = new Product();
        $product->product_name = $data['product_name'];
        $product->product_description =   $data['product_description'];
        $product->product_type =   $data['product_type'];
        $product->product_material =   $data['product_material'];
        $product->product_price =   $data['product_price'];


        $product->category_id  =$data['category_id'];
        $product->subcategory_id  =$data['subcategory_id'];
        $product->product_status =$data['product_status'];
        $product->product_slug =1;
        $product->save();
        $productImages = [];
        if ($request->hasFile('product_image')) {
            foreach ($request->file('product_image') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('fontend/Image'), $imageName);
                    $productImages[] = $imageName;
                }
            }
        }
        foreach ($productImages as $imageName) {
            $image = new ProductImage();
            $image->product_id = $product->id;
            $image->color_id = $request->color_id;

            $image->url = $imageName;
            $image->save();
        }

        // color
        $colorsize = new ColorSize();
        $colorsize->product_id  = $product->id;
        $colorsize->color_id  = $data['color_id'];
        $colorsize->size_id  = $data['size_id'];
        $colorsize->quantity  = $data['product_quantity'];
        $colorsize->save();

        return redirect('product/index')->with('message', 'Product Added Successfully');
    }
}
