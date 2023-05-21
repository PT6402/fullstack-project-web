<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FavoriteController extends Controller
{
    //
    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'product_id' => [
                'required',
                Rule::unique('favorites')->where(function ($query) use ($user_id) {
                    return $query->where('user_id', $user_id);
                })
            ]
        ]);

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->messages(),]);
        }
        $favorite = Favorite::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->input('product_id')
        ]);

        return response()->json(['message' => 'Product added to favorites', $favorite]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $favorite = Favorite::where('user_id', $user->id)->get();
        return response()->json(['favorite' => $favorite]);
        
    }

    public function delete(Request $request)
    {
        $user = $request->user();
        $favorite = Favorite::where('user_id', $user->id)->where('product_id', $request->product_id)->first();
        if (!$favorite) {
            return response()->json(['message' => 'No favorite existed'], 404);
        }
        $favorite->id->delete();

        return response()->json(['favorite' => $favorite]);
    }

    

   
}
