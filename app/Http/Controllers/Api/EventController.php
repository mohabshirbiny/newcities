<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Customer;
use App\Event;
use App\EventCategory;
use App\Http\Controllers\Controller;
use App\OfferCategory;

class EventController extends Controller
{
    public function getAll()
    {
        $event_category_id = request()->event_category_id;
        $location_id = request()->location_id;

        $events = Event::query()->with("category",'city')
                        ->Where('city_id','LIKE',$location_id)
                        ->Where('event_category_id','LIKE',$event_category_id)
                        ->get();

        $eventCatigories = EventCategory::query()->select(['id','name'])->get();
        
        $locations = City::query()->select(['id','name_en','name_ar'])->get();
        
        $data = [
            "events" => $events,
            "event_categories" => $eventCatigories,
            "locations" => $locations,
        ];
        
        return APIResponseController::respond(1, '', $data , 200);
    }

    public function getOne($id)
    {
        if(!Event::find($id)){
            return APIResponseController::respond(0,'no event with this id',[],404); 
        }

        $event = Event::with("category",'city')
                        ->with("organizers")
                        ->with("sponsors")
                        ->with("interested_customers")
                        ->find($id);

        return APIResponseController::respond(1, '', ["event" => $event], 200);
    }

    public function addInterestedCustomer()
    {
        $event_id = request()->event_id;
        $customer_id = request()->customer_id;

        $event = Event::find($event_id);
        $customer = Customer::find($customer_id);
        if(!$event){
            return APIResponseController::respond(0,'no event with this id',[],404); 
        }

        if(!$customer){
            return APIResponseController::respond(0,'no Customer with this id',[],404); 
        }
        
        $event->interested_customers()->sync( $customer->id);
        
        return APIResponseController::respond(1, 'added', [], 200);
    }

    public function removeInterestedCustomer()
    {
        $event_id = request()->event_id;
        $customer_id = request()->customer_id;

        $event = Event::find($event_id);
        $customer = Customer::find($customer_id);
        if(!$event){
            return APIResponseController::respond(0,'no event with this id',[],404); 
        }

        if(!$customer){
            return APIResponseController::respond(0,'no Customer with this id',[],404); 
        }
        
        $event->interested_customers()->detach( $customer->id);
        
        return APIResponseController::respond(1, 'removed', [], 200);
    }


}
