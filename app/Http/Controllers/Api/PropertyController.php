<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Property;

class PropertyController extends Controller
{
    public function getAll()
    {
        $query = Property::query();

        if (request()->compound_id && request()->compound_id != "") {
            $query->where("compound_id", request()->compound_id);
        }

        $records = $query->get();
        
        return APIResponseController::respond(1, "Properties", ["properties" => $records], 200);
    }

    public function getOne($id)
    {
        $details = Property::find($id);
        return APIResponseController::respond(1, "Property details", ["details" => $details], 200);
    }

    public function addInterestedCustomer()
    {
        $property_id = request()->property_id;
        $customer_id = request()->customer_id;

        $property = Property::find($property_id);
        $customer = Customer::find($customer_id);
        if(!$property){
            return APIResponseController::respond(0,'no property with this id',[],404); 
        }

        if(!$customer){
            return APIResponseController::respond(0,'no Customer with this id',[],404); 
        }
        
        $property->interested_customers()->sync( $customer->id);
        
        return APIResponseController::respond(1, 'added', [], 200);
    }

    public function removeInterestedCustomer()
    {
        $property_id = request()->property_id;
        $customer_id = request()->customer_id;

        $property = Property::find($property_id);
        $customer = Customer::find($customer_id);
        if(!$property){
            return APIResponseController::respond(0,'no property with this id',[],404); 
        }

        if(!$customer){
            return APIResponseController::respond(0,'no Customer with this id',[],404); 
        }
        
        $property->interested_customers()->detach( $customer->id);
        
        return APIResponseController::respond(1, 'removed', [], 200);
    }
}
