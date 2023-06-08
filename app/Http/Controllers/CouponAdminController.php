<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CouponAdminController extends Controller
{
    public function index()
    {
        $coupons=Discount::all();
        return view('coupon.index',compact('coupons'));
    }

    public function create()
    {
        return view('coupon.create',);
    }

    public function postCreate(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string',
            'value' => 'required|integer|min:1',
            'code'=>'string|nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'quantity' => 'required|integer|min:1',
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'message' => $validatedData->messages()
            ]);
        }
        // Nếu ngày bắt đầu không được cung cấp, đặt ngày bắt đầu là ngày hiện tại
        $startDate = $request->start_date;
        if (empty($startDate)) {
            $startDate = Carbon::now();
        } else {
            $startDate = Carbon::parse($startDate);
        }

        // Nếu ngày kết thúc không được cung cấp, đặt ngày kết thúc là ngày vô tận
        $endDate = $request->end_date;
        if (empty($endDate)) {
            $endDate = null;
        } else {
            $endDate = Carbon::parse($endDate);
        }
        // Tạo record mới trong bảng discount_codes
        $discount = new Discount();
        $discount->name = $request->name;
        $couponCode = $request->input('code');
        if ($couponCode) {
            // Sử dụng mã khuyến mãi do admin nhập vào
            // Xử lý logic ở đây
            $discount->code=$request->code;
        } else {
            // Tạo mã khuyến mãi ngẫu nhiên
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $couponCode = '';
    
            for ($i = 0; $i < 10; $i++) {
                $randomIndex = mt_rand(0, strlen($characters) - 1);
                $couponCode .= $characters[$randomIndex];
            }
    
            // Xử lý logic với mã khuyến mãi ngẫu nhiên
            $discount->code = $this->generateRandomCode();
        }
        $discount->value = $request->value;
        $discount->start_date =  $startDate;
        $discount->end_date = $endDate;
        $discount->quantity = $request->quantity;
        $discount->save();
        // Trả về mã code
        return redirect('coupon/index')->with('status','Create succesfully');
    }

    private function generateRandomCode()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < 10; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }

    public function edit($id)
    {
        $coupon=Discount::Find($id);
        return view('coupon.update',compact('coupon'));
    }
    public function postEdit(request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string',
            'value' => 'required|integer|min:1',
            'code'=>'string|nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'quantity' => 'required|integer|min:1',
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'message' => $validatedData->messages()
            ]);
        }
        $id=$request->id;
        $coupon=Discount::Find($id);
        $coupon->name = $request->name;
        $couponCode = $request->input('code');
        
        if ($couponCode) {
            // Sử dụng mã khuyến mãi do admin nhập vào
            // Xử lý logic ở đây
            $coupon->code=$request->code;
        } else {
            // Tạo mã khuyến mãi ngẫu nhiên
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $couponCode = '';
    
            for ($i = 0; $i < 10; $i++) {
                $randomIndex = mt_rand(0, strlen($characters) - 1);
                $couponCode .= $characters[$randomIndex];
            }
    
            // Xử lý logic với mã khuyến mãi ngẫu nhiên
            $coupon->code = $this->generateRandomCode();
        }
        $coupon->value = $request->value;
        $startDate = $request->start_date;
        if (empty($startDate)) {
            $startDate = Carbon::now();
        } else {
            $startDate = Carbon::parse($startDate);
        }

        // Nếu ngày kết thúc không được cung cấp, đặt ngày kết thúc là ngày vô tận
        $endDate = $request->end_date;
        if (empty($endDate)) {
            $endDate = null;
        } else {
            $endDate = Carbon::parse($endDate);
        }
        $coupon->start_date =  $startDate;
        $coupon->end_date = $endDate;
        $coupon->quantity = $request->quantity;
        $coupon->save();

        return redirect('coupon/index')->with('status','update successfuly');

    }
    public function delete($id)
    {
        $c = Discount::find($id);
        $c->delete();
        return redirect('coupon/index')->with('status', 'Deleted successful');
    }
}

