<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\EventCategory;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventCategoryController extends Controller
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
            
            $query = EventCategory::query();                                        
            
            return DataTables::of($query)
                ->addColumn("actions", function($record) {
                    $edit_link = route("events-categories.edit", $record->id);
                    $delete_link = route("events-categories.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions'])->make(true);
        } else {
            return view("admin.events_categories.index");
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.events_categories.create");
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
            "title_ar" => "required|string",
            "title_en" => "required|string",
            "icon" => "required|file",
        ]);

        $requestData = $request->except(['icon']);
        
        // send files to rename and upload
        $icon = $this->uploadFile($request->icon , 'EventCategory','icon','image','events_categories_files');

        $cityData = [

            'icon'  => $icon,
            'name'  => serialize($request->name ),
        ];
        
        $EventCategoryData = array_merge($requestData , $cityData);
             //dd($EventCategoryData);
        $eventCategory = EventCategory::create($EventCategoryData);

        return redirect()->route('events-categories.index')->withSuccess( 'Event category created !');

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
        $eventCategory = EventCategory::findorfail($id);
        return view("admin.events_categories.edit", compact("eventCategory"));
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
        $eventCategory = EventCategory::findorfail($id);

        $this->validate($request, [
            "title_ar" => "required|string",
            "title_en" => "required|string",
            "icon" => "file",
        ]);

        $requestData = $request->except(['icon']);
        
        if ($request->icon) { 
            // send files to rename and upload
            $newIcon = $this->uploadFile($request->icon , 'EventCategory','icon','image','events_categories_files');
            $cityData['icon'] = $newIcon;
        }else{
            $cityData['icon'] = $eventCategory->icon;
        }

        $cityData['name']  = serialize($request->name);
        
        $EventCategoryData = array_merge($requestData , $cityData);
             //dd($EventCategoryData);
        $eventCategory->update($EventCategoryData);

        return redirect()->route('events-categories.index')->withSuccess( 'Event category created !');
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
