<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderAdminController extends Controller
{
    public function index()
    {
        $orders=Order::all();
        return view('order.index',compact('orders'));
    }
    public function edit($id)
    {
        $order=Order::find($id);
        return view('order.update',compact('order'));
    }
    public function postEdit(Request $request)
    {
        $order = Order::where('id', $request->id)->first();

        if ($order) {
            $order->status = $request->status;
            $order->save();

            return redirect('order/index')->with('status','update successfully');
        }

        return response()->json(['message' => 'Order not found']);
    }
    
}
