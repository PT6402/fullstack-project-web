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

        $addresses = Address::where('user_id', $user->id)->get();

        return response()->json(['addresses' => $addresses]);
    }
    public function store(Request $request)
    {
        $user = $request->user();
        $addressCount = $user->addresses()->count();
        $isMain = ($addressCount === 0) ? true : $request->input('isMain');
        $address = new Address([
            'user_id' => $user->id,
            'address' => $request->input('address'),
            'isMain' =>  $isMain,
            'city' => $request->input('city'),
            'province' => $request->input('province'),
            'idAdd' => $addressCount + 1,

        ]);

        $user->addresses()->save($address);

        $response = [
            'id' => $addressCount + 1,
            'status' => 200
        ];

        return response()->json($response, 201);
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

        $address = Address::where('user_id', $user->id)->find($request->id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->address = $request->input('address');
        $address->isMain = $request->input('isMain');
        $address->city = $request->input('city');
        $address->province = $request->input('province');
        $address->save();

        return response()->json(['message' => 'Address updated successfully']);
    }
    public function delete(Request $request)
    {
        $user = $request->user();


        $address = Address::where('user_id', $user->id)->where("idAdd",$request->id)->first();

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->delete();

        return response()->json(['message' => 'Address deleted successfully']);
    }
}
