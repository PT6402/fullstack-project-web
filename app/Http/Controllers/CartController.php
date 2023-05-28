<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cartitem;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $cart = Cart::all();
        if (!$cart) {
            return response()->json(['message' => 'cart empty ']);
        }
        return response()->json(['cart' => $cart]);
    }

    public function indexCartitem(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return response()->json(['cart' => 'cart empty']);
        }

        $cartItem = Cartitem::where('cart_id', $cart->id)->with('product')->get();

        if ($cartItem->isEmpty()) {
            return response()->json(['cartitem' => 'cartItem empty']);
        }

        return response()->json(['status' => 200, 'cartItem' =>$cartItem, 'cart' => $cart]);
    }


    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $cart = $request->user()->cart;

        if (!$cart) {
            $cart = new Cart();
            $request->user()->cart()->save($cart);
        }

        $cartItem = $cart->items()->where('product_id', $request->product_id)
            ->where(function ($query) use ($request) {
                $query->where('color_id', $request->color_id)
                    ->Where('size_id', $request->size_id);
            })
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->total_price = $cartItem->quantity * $product->product_price;
            $cartItem->save();
        } else {
            $cartItem = new Cartitem([
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'quantity' => $request->quantity,
                'total_price' => $request->quantity * $product->product_price
            ]);

            $cart->items()->save($cartItem);
        }

        $cart->total_amount += 1;
        $cart->total_price = $cart->items->sum('total_price');
        $cart->save();

        return response()->json(['message' => 'Item added to cart'], 200);
    }


    public function update(Request $request)
    {
        $cartItem = Cartitem::find($request->id);
        $product = Product::find($cartItem->product_id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->color_id = $request->color_id;
        $cartItem->size_id = $request->size_id;
        $cartItem->total_price = $request->quantity * $product->product_price;
        $cartItem->save();

        $cart = $cartItem->cart;
        $cart->total_price = $cart->items->sum('total_price');
        $cart->save();

        return response()->json(['message' => 'Cart item updated'], 200);
    }

    public function edit($id)
    {
        $cartItem = Cartitem::find($id);
        $product_id = $cartItem->product_id;
        return response()->json(['product_id' => $product_id]);
    }

    public function applyDiscount(Request $request)
    {
        $user = $request->user();
        $cart = $user->carts()->first(); // Sử dụng firstOrFail() để lấy giỏ hàng đầu tiên của người dùng
        if (!$cart) {
            return response()->json(['message' => 'cart empty for user']);
        }
        // Áp dụng mã giảm giá
        $discountCode = $request->code;
        $discount = Discount::where('code', $discountCode)->first();
        if (!$discount) {
            return response()->json(['message' => 'code not found']);
        }
        $cart->discount_id = $discount->id; // Lưu ID của mã giảm giá vào trường discount_id trong bảng Cart
        $cart->save();

        // Tính lại tổng giá trị đơn hàng
        $cart->totalPrice(); // Tính tổng giá trị đơn hàng đã được trừ đi giảm giá
        // $cart->save();

        return response()->json(['totalPrice' =>  $cart->total_price]);
    }
    public function viewcart(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->get();
        // $total_amount = $cart->total_amount;
        return response()->json(['status' => 200, 'carts' => $cart]);
    }
}
