<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class PlayerController extends Controller
{

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(["status" => 0, "message" => 'invalid credintials', "data" => (object) []]);
            }
        } catch (JWTException $e) {
            return response()->json(["status" => 0, "message" => "Couldn't create token", "data" => (object) []]);
        }

        $user = auth('api')->user();

        return response()->json(["status" => 1, "message" => "Logged in", "data" => ["user" => $user, "token" => $token]]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:players',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => 0, "message" => $validator->errors()->first(), "data" => (object) []]);
        }

        $email = $request->get('email');

        // DB::beginTransaction();
        $data['user'] = Player::create([
            'name' => $request->get('name'),
            'email' => $email,
            'password' => Hash::make($request->get('password')),
            'phone' => $request->get('phone'),
        ]);

        $data['token'] = auth('api')->fromUser($data['user']);
        // $result = ['user' => $user, "token" => $token];
        // return response()->json(["status" => 1, "message" => "Check your email to verifiy your account.", "data" => (object) []]);
        return response()->json(['status' => 1, "message" => "User registered successfully.", "data" => $data]);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = auth('api')->user()) {
                return response()->json(["status" => 0, "message" => 'User not found', "data" => (object) []], 401);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(["status" => 0, "message" => "Token is expired", "data" => (object) []], 500);
        } catch (TokenInvalidException $e) {
            return response()->json(["status" => 0, "message" => "Token is invalid", "data" => (object) []], 500);
        } catch (JWTException $e) {
            return response()->json(["status" => 0, "message" => "Token is absent", "data" => (object) []], 500);
        }

        $user = auth('api')->user();

        $token = auth('api')->fromUser($user);

        return response()->json(["status" => 1, "message" => "Profile details", "data" => ["user" => $user, "token" => $token]]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        $token = auth('api')->fromUser($user);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:players,email,' . $user->id,
            'phone' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => 0, "message" => $validator->errors()->first(), "data" => (object) []]);
        }

        $player = Player::find($user->id);

        $player->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $new_updated_player = Player::find($user->id);

        return response()->json(["status" => 1, "message" => "Profile updated", "data" => ['user' => $new_updated_player, "token" => $token]]);
    }

    public function logout()
    {
        auth("api")->logout();
        return response()->json(["status" => 1, "message" => "Successfully logged out", "data" => (object) []]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|max:255',
            'password' => 'required|string|max:255|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => 0, "message" => $validator->errors()->first(), "data" => (object) []]);
        }

        $user = auth('api')->user();

        if (Hash::check($request->old_password, $user->password)) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json(["status" => 0, "message" => "New password is the same of old password.", "data" => (object) []]);
            }
            $player = Player::find($user->id);
            $player->update(['password' => bcrypt($request->password)]);
            return response()->json(["status" => 1, "message" => "Password has been changed successfully.", "data" => (object) []]);
        } else {
            return response()->json(["status" => 0, "message" => "Old password is wrong.", "data" => (object) []]);
        }
    }
}
