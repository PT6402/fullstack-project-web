<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'size_name' => 'required|unique:sizes'
        ]);

        $size = new Size();
        $size->size_name = $request->size_name;
        $size->save();

        return response()->json([
            'message' => 'Size created successfully',
            'size' => $size
        ], 201);
    }
    public function index()
    {
        $sizes = Size::all();

        return response()->json(['sizes' => $sizes]);
    }
    public function edit($id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json(['message' => 'Size not found'], 404);
        }

        return response()->json(['size' => $size], 200);
    }
    public function delete($id)
    {
        $size = Size::findOrFail($id);

        // Kiểm tra xem có sản phẩm nào đang sử dụng size này hay không
        if ($size->products()->exists()) {
            return response()->json(['message' => 'Cannot delete size. It is currently used in some products. Please update those products before trying again.'], 400);
        }

        $size->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Size deleted successfully'
        ]);
    }
}
