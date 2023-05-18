<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\ColorSize;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Models\Size;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function placeOrder(Request $request)
    {
        $user = $request->user();
        $cart = $user->carts()->with('items.product', 'items.color', 'items.size')->first();


        /// kiểm tra trong payment,method_payment=credit-card,status_payment có hoàn tất chưa nếu có thì tạo order
        $payment_method = Payment::where('user_id', $user->id)
            ->where('cart_id', $cart->id)
            ->latest()
            ->value('payment_method');
        if ($payment_method == 'credit-card') {
            $status_payment = Payment::where('user_id', $user->id)
                ->where('cart_id', $cart->id)
                ->where('payment_method', $payment_method)
                ->latest()
                ->value('status_payment');
            if ($status_payment == 1) {
                $order = new Order([
                    'user_id' => $user->id,
                    'shipping_address' => $request->input('shipping_address'),
                    'customer_phone' => $request->input('customer_phone'),
                    'total_price' => $cart->total_price,
                    'discount_id' => $cart->discount_id,
                    'payment_method' => $payment_method,
                    'status_payment' => $status_payment == '1' ? true : false,
                    'status' => 0,
                ]);
                $order->save();
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
                    //cập nhật lại số lượng
                    $colorSize = ColorSize::where('color_id', $item->color->id)
                        ->where('size_id', $item->size->id)
                        ->where('product_id', $item->product->id)
                        ->first();
                    if (!$colorSize) {
                        return response()->json([
                            'message' => 'not match color-size'
                        ],);
                    }
                    $colorSize->quantity -= $item->quantity;
                    $colorSize->save();
                    // create review
                    $review = new Review();
                    $review->product_id = $item->product->id;
                    $review->order_id = $order->id;
                    $review->user_id = $user->id;
                    $review->save();
                }
            } else {
                return response()->json([
                    'message' => 'Payment Failed!',
                    'status_payment' => $status_payment
                ],);
            }
        } else {
            $order = new Order([
                'user_id' => $user->id,
                'shipping_address' => $request->input('shipping_address'),
                'customer_phone' => $request->input('customer_phone'),
                'total_price' => $cart->total_price,
                'discount_id' => $cart->discount_id,
                'payment_method' => "COD",
                'status_payment' => false,
                'status' => 0,
            ]);
            $order->save();
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
                //cập nhật lại số lượng
                $colorSize = ColorSize::where('color_id', $item->color->id)
                    ->where('size_id', $item->size->id)
                    ->where('product_id', $item->product->id)
                    ->firstOrFail();
                $colorSize->quantity -= $item->quantity;
                $colorSize->save();
                // create review
                $review = new Review();
                $review->product_id = $item->product->id;
                $review->order_id = $order->id;
                $review->user_id = $user->id;
                $review->save();
            }
        }

        // Tạo mới các bản ghi trong bảng order_item


        // Xóa cart hiện tại
        $cart->delete();

        return response()->json(['message' => 'Order placed successfully'], 201);
    }
    public function updateOrderStatus(Request $request)
    {
        $order = Order::where('id', $request->order_id)
            ->first();

        if ($order) {
            $order->status = $request->status;
            $order->save();

            return response()->json(['message' => 'Order status updated successfully']);
        }

        return response()->json(['message' => 'Order not found']);
    }
    public function cancelOrder(Request $request)
    {
        $user=$request->user();
        $order = Order::where('id', $request->order_id)
            ->where('user_id', $user->id)
            ->first();

        if ($order) {
            // Kiểm tra trạng thái đơn hàng
            if ($order->status == 1 || $order->status == 2) {
                return response()->json(['message' => 'Cannot cancel order with status 1 or 2'], 400);
            }
            // Cập nhật trạng thái đơn hàng thành "Cancelled"
            $order->status = -1;
            $order->save();

            // Cập nhật lại số lượng sản phẩm trong orderItem
            $orderItems = OrderItem::where('order_id', $order->id)->get();

            foreach ($orderItems as $orderItem) {
                $colorSize = ColorSize::where('color_id', $orderItem->color_id)
                    ->where('size_id', $orderItem->size_id)
                    ->where('product_id', $orderItem->product_id)
                    ->first();

                $colorSize->quantity += $orderItem->quantity;
                $colorSize->save();
            }

            return response()->json(['message' => 'Order cancelled successfully']);
        }

        return response()->json(['message' => 'Order not found'], 404);
    }
}
