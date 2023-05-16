<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //


    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $cart = Cart::where('user_id', $user_id)->first();
        if (!$cart) {
            return response()->json([
                'message' => 'cart empty'
            ]);
        }
        $total_price = $cart->total_price;

        $paid = $request->paid;
        if ($paid == '1') {
            $paid = true;
        } else {
            $paid = false;
        }
        $payment = new Payment([
            'user_id' => $user_id,
            'total_price' => $total_price,
            'payment_method' => $request->payment_method,
            'paid' =>  $paid
        ]);

        $payment->save();



        // Return a response to the user
        return response()->json([
            'message' => 'Payment created successfully',
            'payment' => $payment
        ]);
    }
}
