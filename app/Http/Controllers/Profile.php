<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Profile extends Controller
{
    //
    public function update_phone_name(Request $request)
    {
        $user = $request->user();
        $phone_name_user = User::find($user->id)->first();
        $phone_name_user->name = $request->name;
        $phone_name_user->phone = $request->phone;
        $phone_name_user->save();
        return response()->json(['status' => 200]);
    }
}
