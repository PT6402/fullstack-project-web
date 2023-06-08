<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);
        if ($validator->fails()) {
            # code...
            return response()->json(
                ['validation_errors' => $validator->messages(),]
            );
        } else {
            # code...
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken($user->email . '_Token')->plainTextToken;
            return response()->json(
                [
                    'status' => 200,
                    'username' => $user->name,
                    'token' => $token,
                    'message' => 'Register Successfully'
                ]
            );
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|max:191',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            # code...
            return response()->json(
                ['validation_errors' => $validator->messages(),]
            );
        } else {

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(
                    [
                        'status' => 401,
                        'message' => 'Invalid Credentials'
                    ]
                );
            } else {

                if ($user->role_as == 2) {
                    $role = 'admin';
                    $token = $user->createToken($user->email . '_AdminToken', ['server:admin'])->plainTextToken;
                } else {
                    $role = '';
                    $token = $user->createToken($user->email . '_Token', [''])->plainTextToken;
                }
                $address = $user->addresses()->get();
                return response()->json(
                    [
                        'status' => 200,
                        'username' => $user->name,
                        'email' => $user->email,
                        'token' => $token,
                        'message' => 'Logged In Successfully',
                        'role' => $role,
                        'phone' => $user->phone,
                        "address" => $address

                    ]
                );
            }
        }
    }
    public function logout()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $user->tokens()->delete();
        if (auth()->check()) {
        }
        return response()->json(
            [
                'status' => 200,
                'message' => 'Logged Out Successfully'
            ]
        );
    }
    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->tokens()->where('name', $user->email . '_Token')->delete();
        $token = $user->createToken($user->email . '_Token')->plainTextToken;
        return response()->json([
            'status' => 200,
            'token' => $token,
            'message' => 'Token Refreshed Successfully'
        ]);
    }
    public function profile()
    {
        $user = Auth::user();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role_as ?? null
        ]);
    }
    public function mailResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:191',
            'password' => 'required|min:8',
            'password_confirmation' => 'required_with:password|same:password|min:8',
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->messages()]);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 200,
                'message' => 'Password reset successful'
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Password reset failed'
            ]);
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPass' => 'required',
            'newPass' => 'required|min:8',
            'password_confirmation' => 'required_with:newPass|same:newPass|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        /** @var \App\Models\User $user **/
        $user = Auth::user();

        if (!Hash::check($request->oldPass, $user->password)) {
            return response()->json(['error' => 'The old password does not match']);
        }

        $user->update([
            'password' => Hash::make($request->newPass)
        ]);

        $user->tokens()->delete();

        $token = $user->createToken($user->email . '_Token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Password has been reset successfully',
            'token' => $token
        ]);
    }
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['errors' => 'This email is not registered.']);
        }

        $token = app('auth.password.broker')->createToken($user);

        Mail::to($user->email)->send(new ResetPasswordEmail($user, $token));

        return response()->json([
            'message' => 'An email has been sent to your email address. Please check your inbox to reset your password.', 'status' => 200
        ]);
    }
    public function currentLogin()
    {
        if (auth('sanctum')->user()) {
            $user_id = auth('sanctum')->user()->id;

            $user = User::where('id', $user_id)->first();
            $addresses = $user->addresses()->get();
            return response()->json([
                'status' => 200,
                'user' => [
                    'email' => $user->email,
                    'name' => $user->name,
                    'role_as' => $user->role_as,
                    'addresses' => $addresses,
                    'phone' => $user->phone,
                    'user' => $user->name,

                ]

            ]);
        }
    }
}
