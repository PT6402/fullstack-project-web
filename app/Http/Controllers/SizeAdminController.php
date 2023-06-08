<?php

namespace App\Http\Controllers;
use App\Models\Size;

use Illuminate\Http\Request;

class SizeAdminController extends Controller
{
        public function index()
        {
            $sizes = Size::all();
    
            return view('size.index',compact('sizes'));
        }
        public function create()
        {
            return view('size.create');
        }
        public function postCreate(Request $request)
        {
    
            $size = new Size();
            $size->size_name = $request->size_name;
            $size->save();
    
            return redirect('size/index')->with('status','create successfully');
        }
    
        public function edit($id)
        {
            $size = Size::find($id);
    
            return view('size.update',compact('size'));
        }
        public function postEdit(Request $request)
        {
            $id = $request->id;
            $size = Size::Find($id);
            $size->size_name = $request->size_name;
            $size->save();
            return redirect('size/index')->with('status', 'Updated successful');
        }
        public function delete($id)
        {
            $size = Size::findOrFail($id);
    
            // Kiểm tra xem có sản phẩm nào đang sử dụng size này hay không
            if ($size->products()->exists()) {
                return response()->json(['message' => 'Cannot delete size. It is currently used in some products. Please update those products before trying again.'], 400);
            }
    
            
            $size->delete();
            return redirect('size/index')->with('status', 'Deleted successful');
        }
    
}
