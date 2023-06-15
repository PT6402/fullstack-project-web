<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cartitem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;

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

        if ($request->payment_method == "COD") {
            $payment = new Payment([
                'user_id' => $user_id,
                'cart_id' => $cart->id,
                'total_price' => $total_price,
                'payment_method' => "COD",
                'status_payment' => false
            ]);

            $payment->save();



            // Return a response to the user
            return response()->json([
                'status'=>200,
                'message' => 'Payment created successfully',
                'payment' => $payment
            ]);
        } else {

            $cartItems = Cartitem::join('products', 'cartitems.product_id', '=', 'products.id')
                ->where('cart_id', $cart->id)
                ->select(
                    'cartitems.quantity',
                    'products.product_name',
                    'products.product_price',

                )
                ->get();

            $products = $cartItems->map(function ($cartItem) {
                return [
                    'product_name' => $cartItem->product_name,
                    'product_price' => $cartItem->product_price,
                    'quantity' => $cartItem->quantity
                ];
            });



            \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET'));
            $lineItem = [];
            foreach ($products as $product) {
                $lineItem[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product['product_name'], // Truy cập thông tin product_name từ mảng $result

                        ],
                        'unit_amount' => $product['product_price'] * 100, // Truy cập thông tin product_price từ mảng $result
                    ],
                    'quantity' => $product['quantity'], // Truy cập thông tin quantity từ mảng $result
                ];
            }

            $session = \Stripe\Checkout\Session::create([
                'line_items' => $lineItem,
                'mode' => 'payment',
                'success_url' => 'http://localhost:5173/account/success' ,
                'cancel_url' => 'http://localhost:5173/account/cancel',

            ]);

            // return redirect($session->url);
            return response()->json(['status'=>200,'url'=>$session->url]);

        }

    }
    public function success(Request $request)
    {

        $user_id = $request->user()->id;
        $cart = Cart::where('user_id', $user_id)->first();
        if (!$cart) {
            return response()->json([
                'message' => 'cart empty'
            ]);
        }
        //get total_price from cart
        // $total_price = $cart->total_price;
        // format value status_payment

        $payment = new Payment([
            'user_id' => $user_id,
            'cart_id' => $cart->id,
            'total_price' => $cart->total_price,
            'payment_method' =>'credit-card',
            'status_payment' =>  true
        ]);

        $payment->save();



        // Return a response to the user
        return response()->json(['status'=>200,
            'message' => 'Payment created successfully',
            'payment' => $payment
        ]);
    }

}
