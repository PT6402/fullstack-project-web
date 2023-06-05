<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all(['category_name', 'category_slug','id']);


        return response()->json([
            'status' => 200,
            'category' => $categories
        ]);
    }
}
