<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\ColorSize;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function placeOrder(Request $request)
    {
        $user = $request->user();
        $cart = $user->carts()->with('items.product', 'items.color', 'items.size')->first();

        /// kiểm tra trong payment paid có hoàn tất chưa nếu có thì tạo order
        $paid = Payment::where('user_id', $user->id)
            ->where('cart_id', $cart->cart_id)
            ->latest()
            ->value('paid');

        if ($paid == 1) {
            $order = new Order([
                'user_id' => $user->id,
                'shipping_address' => $request->input('shipping_address'),
                'customer_phone' => $request->input('customer_phone'),
                'total_price' => $cart->total_price,
                'status' => 0,
            ]);
            $order->save();
        } else {
            return response()->json([
                'message' => 'Payment Failed!',
                'paid' => $paid
            ],);
        }
        // Tạo mới bản ghi trong bảng order







        // Tạo mới các bản ghi trong bảng order_item
        foreach ($cart->items as $item) {
            $orderItem = new Orderitem([
                'order_id' => $order->id,

                'product_id' => $item->product->id,
                'color_id' => $item->color->id,
                'size_id' => $item->size->id,
                'quantity' => $item->quantity,
                'total_price' => $item->total_price,
            ]);

            $orderItem->save();
            $colorSize = ColorSize::where('color_id', $item->color->id)
                ->where('size_id', $item->size->id)
                ->where('product_id', $item->product->id)
                ->firstOrFail();
            $colorSize->quantity -= $item->quantity;
            $colorSize->save();
        }

        // Xóa cart hiện tại
        $cart->delete();

        return response()->json(['message' => 'Order placed successfully'], 201);
    }
}
