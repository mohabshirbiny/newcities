<?php

namespace App\Http\Controllers\Admin;

use App\EventSponsor;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventSponsorController extends Controller
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
            
            $query = EventSponsor::query();                                        
            
            return DataTables::of($query)
                ->addColumn("actions", function($record) {
                    $edit_link = route("events-sponsors.edit", $record->id);
                    $delete_link = route("events-sponsors.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions'])->make(true);
        } else {
            return view("admin.events_sponsors.index");
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.events_sponsors.create");
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
            "logo" => "required|file",
        ]);

        $requestData = $request->except(['logo']);
        
        // send files to rename and upload
        $logo = $this->uploadFile($request->logo , 'EventSponsor','logo','image','events_sponsors_files');

        $cityData = [

            'logo'  => $logo,
            'name'  => serialize($request->name ),
        ];
        
        $EventSponsorData = array_merge($requestData , $cityData);
             //dd($EventSponsorData);
        $eventSponsor = EventSponsor::create($EventSponsorData);

        return redirect()->route('events-sponsors.index')->withSuccess( 'Event sponsor created !');

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
        $eventSponsor = EventSponsor::findorfail($id);
        return view("admin.events_sponsors.edit", compact("eventSponsor"));
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
        $eventSponsor = EventSponsor::findorfail($id);

        $this->validate($request, [
            "title_ar" => "required|string",
            "title_en" => "required|string",
            "logo" => "file",
        ]);

        $requestData = $request->except(['logo']);
        
        if ($request->logo) { 
            // send files to rename and upload
            $newIcon = $this->uploadFile($request->logo , 'EventSponsor','logo','image','events_sponsors_files');
            $cityData['logo'] = $newIcon;
        }else{
            $cityData['logo'] = $eventSponsor->logo;
        }

        $cityData['name']  = serialize($request->name);
        
        $EventSponsorData = array_merge($requestData , $cityData);
             //dd($EventSponsorData);
        $eventSponsor->update($EventSponsorData);

        return redirect()->route('events-sponsors.index')->withSuccess( 'Event sponsor created !');
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
