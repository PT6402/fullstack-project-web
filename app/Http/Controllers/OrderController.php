<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\ColorSize;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\Size;
use Carbon\Carbon;
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
                    'address' => $request->input('address'),
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'standard' => $request->input('standard'),
                    'express' => $request->input('express'),
                    'city' => $request->input('city'),
                    'province' => $request->input('province'),
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
                'address' => $request->input('address'),
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'standard' => $request->input('standard'),
                'express' => $request->input('express'),
                'city' => $request->input('city'),
                'province' => $request->input('province'),
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
        $order = Order::where('id', $request->id)
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

            return response()->json(['message' => 'Order cancelled successfully','status'=>200]);
        }

        return response()->json(['message' => 'Order not found'], 404);
    }
    public function viewOrder(Request $request)
{
    $user = $request->user();
    $orders = $user->orders()->with('orderItems.product', 'orderItems.color', 'orderItems.size')
    // ->whereNotIn('status', [-1])
    ->get();
    $orders = $orders->map(function ($order) use ($user) {
        $order->orderItems->each(function ($item) use ($order, $user) {
            $item->color_name = $item->color->color_name;
            $item->size_name = $item->size->size_name;
            $item->product_name = $item->product->product_name;
            unset($item->color);
            unset($item->size);
            unset($item->product);

            $product_id = $this->getProductIdByOrderIdAndItemId($order->id, $item->id, $user);
            $item->product_details = $this->getProductDetails($product_id);
            $item->product_image = $this->getProductImage($item->color, $product_id);
            unset($item->color);
        });
        return $order;
    });

    return response()->json(['orders' => $orders]);
}

public function getProductImage($color_id, $product_id)
{
    $productImage = ProductImage::where('color_id', $color_id->id)
                                ->where('product_id', $product_id)
                                ->first();

    if ($productImage) {
        return $productImage->url;
    }

    return null;
}


    public function getProductIdByOrderIdAndItemId($orderId, $itemId, $user)
    {
        $orderItem = $user->orders()->where('id', $orderId)
                                   ->first()
                                   ->orderItems()
                                   ->where('id', $itemId)
                                   ->first();

        if ($orderItem) {
            return $orderItem->product_id;
        }

        return null;
    }

    public function getProductDetails($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $category = $product->subcategory->category;
            $subcategory = $product->subcategory;
            $product_price = $product->product_price;

            return [
                'category_id' => $category->id,
                'category_name' => $category->category_name,
                'subcategory_id' => $subcategory->id,
                'subcategory_name' => $subcategory->subcategory_name,
                'product_price' => $product_price
            ];
        }

        return null;
    }

    // public function getProductImage($colorId, $productId)
    // {
    //     $productImage = ProductImage::join('products', 'products.id', '=', 'product_images.product_id')
    //                                 ->where('product_images.color_id', $colorId)
    //                                 ->where('products.id', $productId)
    //                                 ->select('product_images.url')
    //                                 ->first();

    //     if ($productImage) {
    //         return $productImage->image;
    //     }

    //     return null;
    // }





    // public function viewOrder(Request $request)
    // {
    //     $user = $request->user();
    //     $orders = $user->orders()
    //         ->join('orderitems', 'orders.id', '=', 'orderitems.order_id')
    //         ->join('colors', 'orderitems.color_id', '=', 'colors.id')
    //         ->join('sizes', 'orderitems.size_id', '=', 'sizes.id')
    //         ->join('products', 'orderitems.product_id', '=', 'products.id')
    //         ->select('orders.*', 'colors.color_name', 'sizes.size_name', 'products.product_name')
    //         ->get();

    //     return response()->json(['orders' => $orders]);
    // }
}
