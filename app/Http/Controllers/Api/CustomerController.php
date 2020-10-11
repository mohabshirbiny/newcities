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
            'mobile' => 'required|regex:/(01)[0-9]{9}/|max:11',
        ]);

        if ($validator->fails()) {
            return APIResponseController::respond(0,'validation error',[],422); 
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
            $customer->verification_code=random_int(100000,999999);
            $customer->verification_code_sent=time();
            $customer->save();

        }
        
        $response = $this->sendVerificationSMS($customer);

        return APIResponseController::respond(1,"login",["customer" => $customer],200); 
        
    }

    public function customerVerify(Request $request){

        $validator = Validator::make($request->all(), [
                'mobile' => 'required|regex:/(01)[0-9]{9}/|max:11',
                'code'  =>  'required|integer|min:6',
            ]);

        if ($validator->fails()) {
            return APIResponseController::respond(0,'Validation error',[],422); 
        }
        
        $customer = Customer::where('mobile',$request->mobile)->first();

        if(!$customer){
            return APIResponseController::respond(0,'هذا الرقم غير مسجل لدينا من فضلك قم بتسجيل بياناتك',[],422); 
        }

        $customer->verification_code =(int)$customer->verification_code;

        if($customer->verification_code == $request->code ){
            
            $token = auth('api')->fromUser($customer);

            return APIResponseController::respond(1,'customer data',["customer" => $customer,'token' => $token],200); 

        }else{
            // if code is wrong
            return APIResponseController::respond(0,'wrong code',[],422); 
        }

    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = auth('api')->user()) {
                return APIResponseController::respond(0,'User not found',[],401); 
            }
        } catch (TokenExpiredException $e) {
            return APIResponseController::respond(0,'Token is expired',[],500); 
        } catch (TokenInvalidException $e) {
            return APIResponseController::respond(0,'Token is invalid',[],500); 
        } catch (JWTException $e) {
            return APIResponseController::respond(0,'Token is absent',[],500); 
        }

        $user = auth('api')->user();

        $token = auth('api')->fromUser($user);

        return APIResponseController::respond(1,'Profile details',["user" => $user, "token" => $token]); 
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        $token = auth('api')->fromUser($user);

        $validator = Validator::make($request->all(), [
            'name'      => 'string|max:255',
            'job_title' => 'string|max:255',
            'email'     => 'email|max:255|unique:Customers,email,' . $user->id,
            'image'     => 'image',
            'cv_url'    => 'url',
            'location_governorate'  => 'string',
            'location_city'         => 'string',
            'about'                 => 'string',
            'allow_appearing'                 => 'string',
        ]);

        if ($validator->fails()) {
            return APIResponseController::respond(0,'Vaidation error',[],422); 
        }

        $customer = Customer::find($user->id);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'job_title' => $request->job_title,
            'cv_url' => $request->cv_url,
            'about' => $request->about,
            'location_governorate' => $request->location_governorate,
            'location_city' => $request->location_city,
            'allow_appearing' => $request->allow_appearing,
        ]);

        $new_updated_Customer = Customer::find($user->id);

        return APIResponseController::respond(1,'Profile updated',["customer" => $customer, "token" => $token]); 
    }

    public function logout()
    {
        auth("api")->logout();
        return APIResponseController::respond(1,'Successfully logged out',[],200); 
        
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
