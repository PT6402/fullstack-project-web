<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;




class CategoryAdminController extends Controller
{
    public function index()
    {
        $categorys = Category::all();
        return view('category.index', compact('categorys'));
    }

    public function create()
    {
        $categorys = Category::all();
        return view('category.create', compact('categorys'));
    }

    public function postCreate(Request $request)
    {
        $category = $request->all();
        $category = Category::create([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name, '-'),  
            'category_status'=> $request->category_status
        ]);
        return redirect('category/index')->with('status', 'Created successful');
    }

    public function view($id)
    {
        $category = Category::find($id);
        return view('category.view', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('category.update', compact('category'));
    }

    public function postEdit(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);
        
        
        $category->category_name = $request->category_name;
        $category->category_slug =  strtolower(Str::slug($request->input('category_name'), '-'));
        $category->category_status = $request->category_status;
        // Cập nhật các trường khác nếu cần

        $category->save();

        return redirect('category/index')->with('success', 'Danh mục đã được cập nhật thành công!');
    }
    

    public function delete($id)
    {
        $p = category::find($id);
        $p->delete();
        return redirect('category/index')->with('status', 'Deleted successful');
    }

    //front-end
    public function frontIndex()
    {
        $categorys = category::all();
        return view('front.category', compact('categorys'));
    }

}
