<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\JobCategory;

class JobCategoryController extends Controller
{
    public function getAll()
    {
        
        $records = JobCategory::withCount('jobs')->get();
        
        return APIResponseController::respond(1, "Categories retreived successfully.", ['job_categories' => $records],200); 
    }

    public function getOne($id)
    {
        if(!JobCategory::find($id)){
            return APIResponseController::respond(0,'no Job Category with this id',[],404); 
        }

        $details = JobCategory::with("jobs")->find($id);
        return APIResponseController::respond(1, "Categories retreived successfully.",["job_category" => $details],200); 
    }
}
