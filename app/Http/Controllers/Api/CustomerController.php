<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Customer;
// use App\Http\Controllers\Api\APIResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Traits\SendSMS;

class CustomerController extends Controller
{
    use SendSMS;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|regex:/(01)[0-9]{9}/',
            // 'code'  =>  'required|integer|min:6',
        ]);

        if ($validator->fails()) {
            return APIResponseController::respond(2002,$validator->errors()->toArray(),[],422); 
        }

        $customer = Customer::where('mobile',$request->mobile)->first();

        if(!$customer){

            // Create Customer
            $customer= Customer::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'verification_code' => random_int(100000,999999) ,
                'verification_code_sent' => time() ,
            ]);

        }else{

            $customer->name=$request->name;
            $customer->mobile=$request->mobile;
            // $customer->device_id=$device_id;
            $customer->verification_code=random_int(100000,999999);
            $customer->verification_code_sent=time();
            $customer->save();

        }
        
        $response = $this->sendVerificationSMS($customer);

        // $token = auth('api')->fromUser($customer);

        return APIResponseController::respond(1,[],["customer" => $customer],200); 
        
    }

    public function customerVerify(Request $request){

        $validator = Validator::make($request->all(), [
                'mobile' => 'required|regex:/(01)[0-9]{9}/',
                'code'  =>  'required|integer|min:6',
            ]);

        if ($validator->fails()) {
            return APIResponseController::respond(0,$validator->errors()->toArray(),[],422); 
        }
        
        $customer = Customer::where('mobile',$request->mobile)->first();

        if(!$customer){
            return APIResponseController::respond(0,['error'=>'هذا الرقم غير مسجل لدينا من فضلك قم بتسجيل بياناتك'],[],422); 
        }

        if($customer->verification_code == $request->code ){
            
            $token = auth('api')->fromUser($customer);

            return APIResponseController::respond(1,[],["customer" => $customer,'token' => $token],200); 

        }else{
            // if code is wrong
            return APIResponseController::respond(0,['error'=>'wrong code'],[],422); 
        }

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:Customers',
            'password' => 'required|string|min:6',
            'mobile' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => 0, "message" => $validator->errors()->first(), "data" => (object) []]);
        }

        $email = $request->get('email');

        // DB::beginTransaction();
        $data['user'] = Customer::create([
            'name' => $request->get('name'),
            'email' => $email,
            'password' => Hash::make($request->get('password')),
            'mobile' => $request->get('mobile'),
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
            'email' => 'required|string|email|max:255|unique:Customers,email,' . $user->id,
            'mobile' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => 0, "message" => $validator->errors()->first(), "data" => (object) []]);
        }

        $customer = Customer::find($user->id);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);

        $new_updated_Customer = Customer::find($user->id);

        return response()->json(["status" => 1, "message" => "Profile updated", "data" => ['user' => $new_updated_Customer, "token" => $token]]);
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
            $customer = Customer::find($user->id);
            $customer->update(['password' => bcrypt($request->password)]);
            return response()->json(["status" => 1, "message" => "Password has been changed successfully.", "data" => (object) []]);
        } else {
            return response()->json(["status" => 0, "message" => "Old password is wrong.", "data" => (object) []]);
        }
    }

    public function sendVerificationSMS($customer){
        $customer->verification_code = random_int(100000,999999);
        $customer->verification_code_sent = time();
        $customer->save();
        
        // $response = $this->sendSMS($customer->mobile,"Verify your NewCities account: \n".$customer->verification_code);
        $response = true;

        return $response;
    }

    
}
