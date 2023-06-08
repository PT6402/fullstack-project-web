<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorAdminController extends Controller
{
    public function index()
    {
        $colors = Color::all();

        return view('color.index',compact('colors'));
    }
    public function create()
    {
        return view('color.create');
    }
    public function postCreate(Request $request)
    {

        $color = new Color();
        $color->color_name = $request->color_name;
        $color->color_code = $request->color_code;

        $color->save();

        return redirect('color/index')->with('status','create successfully');
    }

    public function edit($id)
    {
        $color = Color::find($id);

        return view('color.update',compact('color'));
    }
    public function postEdit(Request $request)
    {
        $id = $request->id;
        $color = Color::Find($id);
        $color->color_name = $request->color_name;
        $color->save();
        return redirect('color/index')->with('status', 'Updated successful');
    }
    public function delete($id)
    {
        $color = color::findOrFail($id);

        // Kiểm tra xem có sản phẩm nào đang sử dụng size này hay không
        if ($color->products()->exists()) {
            return response()->json(['message' => 'Cannot delete size. It is currently used in some products. Please update those products before trying again.'], 400);
        }

        
        $color->delete();
        return redirect('color/index')->with('status', 'Deleted successful');
    }
}
