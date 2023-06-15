<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = $request->user();

        $addresses = Address::where('user_id', $user->id)
            ->orderByDesc('isMain') // Sắp xếp theo isMain giảm dần (true đứng đầu)
            ->get();

        return response()->json(['addresses' => $addresses]);
    }
    public function store(Request $request)
    {
        $user = $request->user();
        $addressCount = $user->addresses()->count();
        $isMain = ($addressCount === 0) ? true : $request->input('isMain');
        if ($isMain && $user->addresses()->where('isMain', true)->exists()) {
            $user->addresses()->update(['isMain' => false]);
        }
        $address = new Address([
            'user_id' => $user->id,
            'address' => $request->input('address'),
            'isMain' =>  $isMain,
            'label'=>$request->input('label'),
            'city' => $request->input('city'),
            'province' => $request->input('province'),
            'idAdd' => $user->name.$request->input('address').$request->input('city').$request->input('province'),

        ]);

        $user->addresses()->save($address);

        // $response = [
        //     'id' => $addressCount + 1,
        //     'status' => 200
        // ];

        return response()->json(['status' => 200, 'id' => $address->idAdd]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();

        $address = Address::where('user_id', $user->id)->find($request->addressId);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        return response()->json(['address' =>  $address]);
    }
    public function update(Request $request)
    {
        $user = $request->user();
        $idAdd = $request->id;
        $isMain = $request->input('isMain');

        $address = Address::where('user_id', $user->id)->where('idAdd', $idAdd)->first();

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        if ($isMain) {
            $user->addresses()->where('idAdd', '!=', $idAdd)->update(['isMain' => false]);
        }

        $address->address = $request->input('address');
        $address->isMain = $isMain;
        $address->label = $request->input('label');
        $address->city = $request->input('city');
        $address->province = $request->input('province');
        $address->save();

        // Lấy tất cả địa chỉ của người dùng và sắp xếp lại theo idAdd
        // $addressList = $user->addresses()->orderBy('idAdd')->get();

        // // Gán lại giá trị idAdd dựa trên chỉ số index
        // $addressCount = count($addressList);
        // for ($i = 0; $i < $addressCount; $i++) {
        //     $addressList[$i]->idAdd = $i + 1;
        //     $addressList[$i]->save();
        // }

        return response()->json(['message' => 'Address updated successfully', ]);
    }





    public function delete(Request $request)
{
    $user = $request->user();
    $idAdd = $request->id;

    // Lấy tất cả các địa chỉ của người dùng
    $addressList = $user->addresses()->get();

    // Tìm địa chỉ cần xóa và kiểm tra xem nó có isMain là true hay không
    $addressToDelete = $addressList->where('idAdd', $idAdd)->first();

    if (!$addressToDelete) {
        return response()->json(['message' => 'Address not found'], 404);
    }

    $isMainDeleted = $addressToDelete->isMain;

    // Xóa địa chỉ cần xóa từ cơ sở dữ liệu
    $addressToDelete->delete();

    // Tạo một mảng mới để lưu trữ các địa chỉ sau khi xóa
    $newAddressList = [];

    foreach ($addressList as $address) {
        if ($address->idAdd !== $idAdd) {
            $newAddressList[] = $address;
        }
    }

    // Kiểm tra xem trong mảng mới có địa chỉ isMain là true hay không
    $hasMainAddress = collect($newAddressList)->contains('isMain', true);

    // Nếu không có địa chỉ isMain là true và địa chỉ cần xóa có isMain=true, đặt địa chỉ đầu tiên trong mảng mới làm isMain
    if (!$hasMainAddress && $isMainDeleted && count($newAddressList) > 0) {
        $newAddressList[0]->isMain = true;
    }

    // Gán lại giá trị idAdd cho các địa chỉ trong mảng mới
    // for ($i = 0; $i < count($newAddressList); $i++) {
    //     $newAddressList[$i]->idAdd = $i + 1;
    // }

    // Lưu các thay đổi vào cơ sở dữ liệu
    $user->addresses()->saveMany($newAddressList);

    return response()->json(['message' => 'Address deleted successfully']);
}


    // public function delete(Request $request)
    // {
    //     // Logic xóa địa chỉ và gán lại isMain

    //     return response()->json(['message' => 'Address deleted successfully']);
    // }
}
