<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Size;
use App\Models\Category;
use App\Models\ColorSize;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;


class InventoryController extends Controller
{
    public function index()
    {
        $colorsize = ColorSize::all();
        return view('inventory.index', compact('colorsize'));
    }

    public function edit($id)
    {  
        $colorsize_product = ColorSize::where('id',$id)->first();
        $color_product = Color::orderby('id','desc')->get();
        $size_product = Size::orderby('id','desc')->get();
        return view('inventory.edit', compact('colorsize_product','color_product','size_product'));
    }

    public function postedit(Request $request)
    {
        $data =$request->all();
        $colorsize = ColorSize::where('id', $data['colorsize_id'])->first();
                if ($colorsize) {
                    $colorsize->color_id  = $data['color_id'];
                    $colorsize->size_id  = $data['size_id'];
                    $colorsize->quantity  = $data['product_quantity'];
                $colorsize->save();
        }
    
                
                return redirect('inventory/index')->with('message', 'Updated Successfully');
    }

    public function delete($id)
    {
          
        DB::table('color_sizes')->where('id',$id)->delete();
        return redirect('inventory/index')->with('message', 'Deleted Successfully');
    }
}
