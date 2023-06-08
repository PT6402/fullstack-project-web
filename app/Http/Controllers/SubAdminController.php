<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Support\Str;



class SubAdminController extends Controller
{
    
    public function index()
    {
        $subcategories = Subcategory::all();
        return view('subcategory.index', compact('subcategories'));
    }
    public function create()
    {
        $categorys=Category::all();
        return view('subcategory.create',compact('categorys'));
    }
    public function postCreate(request $request)
    {
        $subcategory = $request->all();
        
        $s = new Subcategory($subcategory);
        $subcategory = Subcategory::create([
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => Str::slug($request->subcategory_name, '-'),  
            'category_id' => $request->category_id
        ]);
        
        return redirect('subcategory/index')->with('status', 'Created successful');
        
    }

    public function view($id)
    {
        $categorys = Category::find($id);
        return view('subcategory.view', compact('categorys'));
    }
    public function edit($id)
    {
        $subcategory = Subcategory::find($id);
        return view('subcategory.update', compact('subcategory'));
    }
    public function postEdit(Request $request)
    {
        $id = $request->id;
        $subcategory = Subcategory::find($id);
        $subcategory->subcategory_name = $request->subcategory_name;
        $subcategory->subcategory_slug = strtolower(Str::slug($request->input('subcategory_name'), '-'));
        $subcategory->category_id=$request->category_id;
        $subcategory->subcategory_status=$request->subcategory_status;

        $subcategory->save();
        return redirect('subcategory/index')->with('status', 'Updated successful');
    }

    public function delete($id)
    {
        $s = Subcategory::find($id);
        $s->delete();
        return redirect('subcategory/index')->with('status', 'Deleted successful');
    }
    
}
