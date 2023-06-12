<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categorys = Category::latest();
        $category = new  Category;
        $columnNames = $category->getColumnNames();
        $category_name = $categorys->category_name;
        $category_slug = $categorys->category_slug;
        return response()->json([
            'status' => 200,
            'headerTable' =>  $columnNames,
            'bodyTable' => $categorys,
            'category_name' => $category_name,
            'category_slug' => $category_slug,

        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'category_name' => 'required|max:255|unique:categories',
        ]);
        if ($validator->fails()) {
            return response()->json([
                '
                message' => $validator->messages()
            ]);
        }

        $category = new Category([
            'category_name' => $request->input('category_name'),
            'category_slug' =>  strtolower(Str::slug($request->input('category_name'), '-')),
            'category_status' => $request->input('category_status')

        ]);

        $category->save();

        return response()->json(['message' => 'Category created successfully!', 'status' => 200], 201);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json([
            'category' => $category,
            'status' => 200
        ]);
    }
    public function subcategories($categoryId)
    {
        // Lấy tất cả subcategory của category có id là $categoryId
        $subcategories = SubCategory::where('category_id', $categoryId)->get();

        // Trả về danh sách subcategory dưới dạng JSON
        return response()->json($subcategories);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'category_id' => 'exists:categories,id',
            'category_name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ]);
        }
        $category_id = $request->category_id;
        $category = Category::find($category_id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->category_name = $request->input('category_name');
        $category->category_status = $request->input('category_status');
        $category->category_slug = strtolower(Str::slug($request->input('category_name'), '-'));
        $category->save();

        return response()->json(['message' => 'Category updated successfully!',  'status' => 200, 'status_cate' => $request->input('category_status')]);
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $subcategories = $category->subcategories;
        if ($subcategories->isNotEmpty()) {
            $subcategoryNames = $subcategories->pluck('subcategory_name')->implode(', ');
            return response()->json(['message' => "Cannot delete category. The following subcategories are still using it: $subcategoryNames", 'status' => 400]);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully.', 'status' => 200]);
    }
}
