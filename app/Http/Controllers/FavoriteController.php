<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|unique:favorite_products,product_id'
        ]);
       if ($validator->fails()){
        return response ()->json( ['validation_errors' => $validator->messages(),]);
       }
        $favorite = Favorite::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->input('product_id')
        ]);

        return response()->json(['message' => 'Product added to favorites', $favorite]);
    }
}
