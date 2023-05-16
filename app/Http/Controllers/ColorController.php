<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validate input data
        $validatedData = $request->validate([
            'color_name' => 'required|unique:colors',
            'color_code' => 'required|unique:colors',
        ]);

        // Create new color
        $color = new Color;
        $color->color_name = $request->input('color_name');
        $color->color_code = $request->input('color_code');
        $color->save();

        // Redirect to the list of colors
        return response()->json(['success', 'Color created successfully.']);
    }
    public function index()
    {
        $colors = Color::all();
        return response()->json(['colors' => $colors]);
    }
    public function edit($id)
    {
        $color = Color::findOrFail($id);

        return response()->json([
            'color' => $color
        ]);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'color_name' => 'required|string|max:255',
            'color_code' => 'required|string|max:7',
            'color_id' => 'required|exists:colors,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $color_id = $request->color_id;
        $color = Color::findOrFail($color_id);

        $color->color_name = $request->input('color_name');
        $color->color_code = $request->input('color_code');
        $color->save();

        return response()->json(['message' => 'Color updated successfully', 'color' => $color], 200);
    }
    public function delete($id)
    {
        $color = Color::find($id);

        // Check if any products are using this color
        $products = $color->products;
        if (count($products) > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete color. It is currently used in some products. Please update those products before trying again.'
            ], 400);
        }

        $color->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Color deleted successfully'
        ]);
    }
}
