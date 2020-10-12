<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\JobCategory;
use App\SectionData;
use App\Vendor;

class JobController extends Controller
{
    public function getAll()
    {
        $vendor_id = request()->vendor_id ;
        $job_category_id = request()->job_category_id;
        $location_id = request()->location_id;
        $locationVendorsIds = Vendor::where('city_id', $location_id)->pluck('id');
        // dd($locationVendorsIds);

        $jobs = Job::query()->with("job_category",'vendor')
                        ->orWhereIn('vendor_id',$locationVendorsIds)
                        ->Where('vendor_id','LIKE',$vendor_id)
                        ->Where('job_category_id','LIKE',$job_category_id)
                        ->get();

        $jobsCatigories = JobCategory::query()->select(['id','name'])->withCount("jobs")->get();
        $vendors = Vendor::all();
        $locations = City::query()->select(['id','name_en','name_ar'])->get();
        
        $section = SectionData::where('model','Job')->first();

        $data = [
            "jobs" => $jobs,
            "jobs_categories" => $jobsCatigories,
            "vendors" => $vendors,
            "locations" => $locations,
        ];

        return APIResponseController::respond(1,'jobs retreived successfully',$data,200); 
    }

    public function getOne($id)
    {
        if(!Job::find($id)){
            return APIResponseController::respond(0,'no Job with this id',[],404); 
        }

        $details = Job::with("job_category")->find($id);
        return APIResponseController::respond(1,"job retreived successfully.", ['job' => $details],200); 
    }
}
