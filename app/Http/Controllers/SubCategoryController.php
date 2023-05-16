<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategorys = Subcategory::all();
        $subcategory = new Subcategory;
        $columnNames = $subcategory->getColumnNames();

    return response()->json([
        'status' => 200,
        'headerTable'=>  $columnNames,
        'bodyTable' => $subcategorys
    ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_name' => 'required|max:255',
        ]);

        $category = Category::findOrFail($request->category_id);

        $subcategory = new Subcategory([
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => Str::slug($request->subcategory_name, '-'),
        ]);

        $category->subcategories()->save($subcategory);
        $category->increment('subcategory_count');

        return response()->json(['message' => 'Subcategory created successfully!', 'status' => 200], 201);
    }
    public function edit($id)
    {
        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return response()->json(['message' => 'Subcategory not found'], 404);
        }

        return response()->json(['subcategory' => $subcategory,'status'=>200]);
    }

    public function update(Request $request)
{
    $request->validate([
        'subcategory_name' => 'required|max:255',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'required|exists:subcategories,id',
    ]);

    $subcategory = Subcategory::find($request->input('subcategory_id'));

    if (!$subcategory) {
        return response()->json(['message' => 'Subcategory not found'], 404);
    }

    $subcategory->subcategory_name = $request->input('subcategory_name');
    $subcategory->subcategory_status = $request->input('subcategory_status');
    $subcategory->subcategory_slug = Str::slug($request->input('subcategory_name'), '-');
    $new_category_id = $request->input('category_id');

    if ($subcategory->category_id !== $new_category_id) {
        $old_category = Category::find($subcategory->category_id);
        $old_category->subcategory_count = Subcategory::where('category_id', $old_category->id)->count() - 1;
        $old_category->save();

        $subcategory->category_id = $new_category_id;

        $new_category = Category::find($new_category_id);
        $new_category->subcategory_count = Subcategory::where('category_id', $new_category->id)->count() + 1;
        $new_category->save();
    }

    $subcategory->save();

    return response()->json(['message' => 'Subcategory updated successfully!', 'subcategory' => $subcategory,'status'=>200]);
}
public function delete($id)
{
    $subcategory = Subcategory::find($id);

    if (!$subcategory) {
        return response()->json(['message' => 'Subcategory not found'], 404);
    }

    $products = $subcategory->products;
    if ($products->count() > 0) {
        $productNames = $products->pluck('product_name')->implode(', ');
        return response()->json(['message' => "The subcategory is still used by the following products: $productNames"], 400);
    }

    $category = Category::find($subcategory->category_id);

    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    $subcategory->delete();

    $category->decrement('subcategory_count', 1);
    $category->save();

    return response()->json(['message' => 'Subcategory deleted successfully!','status'=>200]);
}

}
