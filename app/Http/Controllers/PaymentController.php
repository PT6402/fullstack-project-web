<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    //


    public function store(Request $request)
    {
        //check valid of request
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:COD,credit-card',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ]);
        }
        // find cart of user
        $user_id = $request->user()->id;
        $cart = Cart::where('user_id', $user_id)->first();
        if (!$cart) {
            return response()->json([
                'message' => 'cart empty'
            ]);
        }
        //get total_price from cart
        $total_price = $cart->total_price;
        // format value status_payment
        $status_payment = $request->status_payment;
        if ($request->status_payment == null) {

            if ($request->payment_method == "COD") {
                $status_payment = true;
            }else{
                return response()->json([
                    'message' => 'status_payment is require'
                ]);
            }
        } else {
            if ($status_payment == '1') {
                $status_payment = true;
            } else {
                $status_payment = false;
            }
        }

        // add payment
        $payment = new Payment([
            'user_id' => $user_id,
            'cart_id' => $cart->id,
            'total_price' => $total_price,
            'payment_method' => $request->payment_method,
            'status_payment' =>  $status_payment
        ]);

        $payment->save();



        // Return a response to the user
        return response()->json([
            'message' => 'Payment created successfully',
            'payment' => $payment
        ]);
    }
}
