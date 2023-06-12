<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    public function findReview(Request $request)
    {
        $user = $request->user();

        $order = Order::where('id', $request->order_id)
            ->where('user_id', $user->id)
            ->first();
        if ($order) {
            $orderItem = $order->orderItems()->where('product_id', $request->product_id)->first();
            // $orderItem=$request->orderItem_id;

            if ($orderItem) {

                $status_order = $order->status;
                if ($status_order == 1 || $status_order == 0) {
                    return response()->json(['message' => 'Not reviewed']);
                }

                $comment = Review::where('user_id',  $user->id)
                    ->where('order_id', $order->id)
                    ->where('product_id', $request->product_id)
                    ->where('status', 0)
                    ->first();
                if (!$comment) {
                    return response()->json([
                        'message' => 'review of product not found'
                    ]);
                }
                return response()->json([
                    'review_product' => $comment
                ]);
            } else {
                return response()->json(['message' => 'Product is not in the order']);
            }
        } else {
            return response()->json(['message' => 'Order not found']);
        }
    }
    public function review(Request $request)
    {
        $review = Review::find($request->id);
        if (!$review) {
            return response()->json([
                'message' => 'review not found'
            ]);
        }

        $review->comment = $request->input('comment');

        $review->rate = $request->input('rate');
        $review->status = $request->input('status');
        $review->save();
        return response()->json(['message' => 'Review create successfully', 'status' => 200]);
    }
}
