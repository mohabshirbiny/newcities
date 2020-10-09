<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\JobCategory;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class JobCategoryController extends Controller
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
            
            $query = JobCategory::query();                                        
            
            return DataTables::of($query)
                ->addColumn("actions", function($record) {
                    $edit_link = route("jobs-categories.edit", $record->id);
                    $delete_link = route("jobs-categories.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions'])->make(true);
        } else {
            return view("admin.jobs_categories.index");
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.jobs_categories.create");
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
            "name.ar" => "required|string",
            "name.en" => "required|string",
            "icon" => "required|file",
        ]);

        $requestData = $request->except(['icon']);
        
        // send files to rename and upload
        $icon = $this->uploadFile($request->icon , 'JobCategory','icon','image','jobs_categories_files');

        $jobCategoryData = [

            'icon'  => $icon,
            'name'  => serialize($request->name ),
        ];
        
        $JobCategoryData = array_merge($requestData , $jobCategoryData);
             //dd($JobCategoryData);
        $jobCategory = JobCategory::create($JobCategoryData);

        return redirect()->route('jobs-categories.index')->withSuccess( 'Job category created !');
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
        $jobCategory = JobCategory::findorfail($id);
        return view("admin.jobs_categories.edit", compact("jobCategory"));
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
        $jobCategory = JobCategory::findorfail($id);

        $this->validate($request, [
            "name.ar" => "required|string",
            "name.en" => "required|string",
            "icon" => "file",
        ]);

        $requestData = $request->except(['icon']);
        
        if ($request->icon) { 
            // send files to rename and upload
            $newIcon = $this->uploadFile($request->icon , 'JobCategory','icon','image','jobs_categories_files');
            $jobCategoryData['icon'] = $newIcon;
        }else{
            $jobCategoryData['icon'] = $jobCategory->icon;
        }

        $jobCategoryData['name']  = serialize($request->name);
        
        $JobCategoryData = array_merge($requestData , $jobCategoryData);
             //dd($JobCategoryData);
        $jobCategory->update($JobCategoryData);

        return redirect()->route('jobs-categories.index')->withSuccess( 'Job category created !');
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
