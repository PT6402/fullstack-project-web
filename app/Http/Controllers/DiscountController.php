<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{


    public function store(Request $request)
    {

        $validatedData = Validator::make($request->all(),[
            'name' => 'required|string',
            'value' => 'required|integer|min:1',
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
        $discount->code = $this->generateRandomCode();
        $discount->value = $request->value;
        $discount->start_date =  $startDate;
        $discount->end_date = $endDate;
        $discount->quantity = $request->quantity;
        $discount->save();



        // Trả về mã code
        return response()->json([
            'message' => 'Discount created successfully',
            'code' => $discount->code
        ]);
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
    public function show()
    {
        $discount = Discount::all();
        return response()->json(['discount' => $discount]);
    }
    public function edit($id)
    {
        // Tìm mã giảm giá cần sửa đổi
        $discountCode = Discount::find($id);
        if (!$discountCode) {
            return response()->json(['message' => 'Discount code not found'], 404);
        }
        return response()->json(['discountCode' => $discountCode]);
    }
    public function update(Request $request)
    {
        $validatedData = Validator::make($request->all(),[
            'name' => 'required|string',
            'value' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'quantity' => 'required|integer|min:1',
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'message' => $validatedData->messages()
            ]);
        }
        $discount  = Discount::find($request->id);

        // Cập nhật các trường thông tin của discount
        $discount->name = $request->input('name');
        $discount->value = $request->input('value');
        $discount->start_date = $request->input('start_date');
        $discount->end_date = $request->input('end_date');
        $discount->quantity = $request->input('quantity');
        // Lưu thay đổi vào cơ sở dữ liệu
        $discount->save();
        // Trả về thông tin của mã giảm giá sau khi được cập nhật
        return response()->json([
            'message' => 'Discount updated successfully'
        ]);
    }
    public function delete($id)
    {
        $discount = Discount::find($id);

        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        $discount->delete();

        return response()->json([
            'message' => 'Discount deleted successfully'
        ]);
    }
}
