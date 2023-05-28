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

        $address = new Address([
            'user_id' => $user->id,
            'address' => $request->input('address'),
            'default_address' => $request->input('default_address', false),
            'city_province' => $request->input('city_province'),
            'note' => $request->input('note'),
        ]);

        $user->addresses()->save($address);

        return response()->json([
            'message' => 'Address added successfully',
            'status' => 200
        ], 201);
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

        $address = Address::where('user_id', $user->id)->find($request->addressId);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->address = $request->input('address');
        $address->default_address = $request->input('default_address');
        $address->city_province = $request->input('city_province');
        $address->note = $request->input('note');
        $address->save();

        return response()->json(['message' => 'Address updated successfully']);
    }
    public function delete(Request $request)
    {
        $user = $request->user();

        $addressId = $request->address_id;
        $address = Address::where('user_id', $user->id)->find($addressId);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->delete();

        return response()->json(['message' => 'Address deleted successfully']);
    }
}
