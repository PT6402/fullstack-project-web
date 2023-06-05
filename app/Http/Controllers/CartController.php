<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cartitem;
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductImage;
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

    // public function indexCartitem(Request $request)
    // {
    //     $user = $request->user();
    //     $cart = Cart::where('user_id', $user->id)->first();

    //     if (!$cart) {
    //         return response()->json(['cart' => 'cart empty']);
    //     }

    //     $cartItems = Cartitem::join('colors', 'cartitems.color_id', '=', 'colors.id')
    //         ->join('sizes', 'cartitems.size_id', '=', 'sizes.id')
    //         ->select('cartitems.*', 'colors.color_name', 'sizes.size_name')
    //         ->where('cart_id', $cart->id)
    //         ->with(['product' => function ($query) {
    //             $query->select('id', 'product_name', 'product_type', 'product_material', 'product_description', 'product_price', 'category_id', 'subcategory_id', 'product_slug', 'product_status');
    //             $query->with(['images' => function ($query) {
    //                 $query->select('id', 'product_id', 'color_id', 'url', 'is_main');
    //             }]);
    //         }])
    //         ->get();

    //     if ($cartItems->isEmpty()) {
    //         return response()->json(['cartitem' => 'cartItem empty']);
    //     }

    //     $cartItems = $cartItems->map(function ($item) {
    //         $item->makeHidden(['created_at', 'updated_at']);
    //         $item->product->makeHidden(['created_at', 'updated_at']);

    //         $filteredImages = collect();

    //         foreach ($item->product->images as $image) {
    //             if ($image->color_id == $item->color_id) {
    //                 $filteredImages->push($image);
    //             }
    //         }

    //         $item->product->images = $filteredImages;

    //         return $item;
    //     });

    //     $cart = $cart->makeHidden(['created_at', 'updated_at']);

    //     return response()->json(['status' => 200, 'cartItem' => $cartItems, 'cart' => $cart]);
    // }





    public function indexCartitem(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->first();

        $cartItems = Cartitem::join('products', 'cartitems.product_id', '=', 'products.id')
            ->join('colors', 'cartitems.color_id', '=', 'colors.id')
            ->join('sizes', 'cartitems.size_id', '=', 'sizes.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->where('cart_id', $cart->id)
            ->select(
                'cartitems.id',
                'cartitems.cart_id',
                'cartitems.product_id',
                'cartitems.color_id',
                'cartitems.size_id',
                'cartitems.quantity',
                'cartitems.total_price',
                'colors.color_name',
                'sizes.size_name',
                'products.id as product_id',
                'products.product_name',
                'products.product_slug',
                'products.product_price',
                'products.product_description',
                'products.product_type',
                'products.product_material',
                'categories.category_name',
                'subcategories.subcategory_name'
            )
            ->get();

        $products = $cartItems->groupBy('product_id')->map(function ($items) {
            $product = $items->first();

            $colorSizes = [];

            $items->groupBy('color_id')->each(function ($colorItems) use ($product, &$colorSizes) {
                $color = $colorItems->first();
                $sizeIds = $colorItems->pluck('size_id')->unique();

                $sizes = $sizeIds->map(function ($sizeId) use ($colorItems) {
                    $size = $colorItems->firstWhere('size_id', $sizeId);

                    $categoryId = ucwords(str_replace(' ', '', $size->category_name));
                    $productName = ucwords(str_replace(' ', '', $size->product_name));
                    $colorName = ucwords(str_replace(' ', '', $size->color_name));
                    $sizeName = ucwords(str_replace(' ', '', $size->size_name));
                    $colorId = $size->color_id;

                    $sizeId = $productName . $colorName . $sizeName . $colorId;
                    return [
                        'id' => $sizeId,
                        'size_name' => $size->size_name,
                        'quantity' => $size->quantity,
                    ];
                });

                $colorName = $color->color_name;

                $images = ProductImage::where('product_id', $product->product_id)
                    ->where('color_id', $color->color_id)
                    ->select('url', 'id', 'is_main')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'url' => $item->url,
                            'id' => $item->id,
                            'is_main' => $item->is_main,
                        ];
                    });

                $categoryName = strtolower(str_replace(' ', '-', $product->category_name));
                $productName = strtolower(str_replace(' ', '-', $product->product_name));
                $colorSlug = strtolower(str_replace(' ', '-', $colorName));
                $url = $categoryName . '-' . $productName . '-' . $colorSlug;

                // Tính toán giá tổng cộng cho mỗi màu sắc
                $totalPrice = $colorItems->sum('total_price');
                $productId = $product->product_id;
                $colorId =  $productId . '000' . $color->color_id;
                $colorSizes[] = [
                    'id' =>  $colorId,
                    'color_name' => $colorName,
                    'sizes' => $sizes,
                    'images' => $images,
                    'url' => $url,
                    'total_price' => $totalPrice, // Thêm giá tổng cộng cho màu sắc
                ];
            });

            $urls = collect($colorSizes)->pluck('url')->toArray();



            return [
                'id' => $product->product_id,
                'product_name' => $product->product_name,
                'product_slug' => $product->product_slug,
                'product_price' => $product->product_price,
                'product_description' => $product->product_description,
                'product_type' => $product->product_type,
                'product_material' => $product->product_material,
                'category_name' => $product->category_name,
                'subcategory_name' => $product->subcategory_name,
                'colorSizes' => $colorSizes,
                'product_url' => $urls,

            ];
        });

        return response()->json([
            'status' => 200,
            'items' => $products->values(),
            'totalAmount' => $cart->total_amount,
            'discount' => $cart->discount,
            'totalPrice' => $cart->total_price,
        ]);
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

        return response()->json(['status'=>200]);
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
