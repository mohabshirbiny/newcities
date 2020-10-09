<?php

namespace App\Http\Controllers\Admin;

use App\Job;
use App\Http\Controllers\Controller;
use App\JobCategory;
use App\Traits\UploadFiles;
use App\Vendor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JobController extends Controller
{
    use UploadFiles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            
            $query = Job::query();                                        
            
            return DataTables::of($query)
                ->addColumn("actions", function($record) {
                    $edit_link = route("jobs.edit", $record->id);
                    $delete_link = route("jobs.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions'])->make(true);
        } else {
            return view("admin.jobs.index");
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = JobCategory::query()->select(['id','name'])->get();                                        
        $vendors = Vendor::query()->select(['id','title_en','title_ar'])->get();                                        

        return view("admin.jobs.create",compact('categories','vendors'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // dd($request->all());
        $this->validate($request, [
            "vendor_id" => "required|integer",
            "job_category_id" => "required|integer",
            "location.ar" => "required",
            "location.en" => "required",
            "post_title.ar" => "required",
            "post_title.en" => "required",
            "post_description.ar" => "required",
            "post_description.en" => "required",
            "job_requirements.ar" => "required",
            "job_requirements.en" => "required",
            "post_date" => "required|date",
            "attachment_url" => "required|url",
            "email" => "required|email",
            "mobile" => "required|integer",
        ]);
        // dd($request->all());

        $requestData = $request->except(['_token']);

        $jobData = [
            'location'  => serialize($request->location ),
            'post_title'     => serialize($request->post_title ),
            'post_description'     => serialize($request->post_description ),
            'job_requirements'     => serialize($request->job_requirements ),
        ];
        
        $jobData = array_merge($requestData , $jobData);
            // dd($jobData);
        $job = Job::create($jobData);

        return redirect()->route('jobs.index')->withSuccess( 'job created !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $JobCategories = JobCategory::query()->select(['id','name'])->get();                                        
        $vendors = Vendor::query()->select(['id','title_en','title_ar'])->get();                                        

        $job = Job::findorfail($id);
        
        return view("admin.jobs.edit", compact("JobCategories",'job','vendors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $job = Job::findorfail($id);

        $this->validate($request, [
            "vendor_id" => "required|integer",
            "job_category_id" => "required|integer",
            "location.ar" => "required",
            "location.en" => "required",
            "post_title.ar" => "required",
            "post_title.en" => "required",
            "post_description.ar" => "required",
            "post_description.en" => "required",
            "job_requirements.ar" => "required",
            "job_requirements.en" => "required",
            "post_date" => "required|date",
            "attachment_url" => "required|url",
            "email" => "required|email",
            "mobile" => "required",
        ]);
    // dd($request->all());
        $requestData = $request->except(['_token']);

        $jobData = [
            'location'  => serialize($request->location ),
            'post_title'     => serialize($request->post_title ),
            'post_description'     => serialize($request->post_description ),
            'job_requirements'     => serialize($request->job_requirements ),
        ];
        
        $jobData = array_merge($requestData , $jobData);
            // dd($jobData);
        $job->update($jobData);

        return redirect()->route('jobs.index')->withSuccess( 'job Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
