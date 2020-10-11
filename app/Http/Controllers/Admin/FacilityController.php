<?php

namespace App\Http\Controllers\Admin;

use App\Facility;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FacilityController extends Controller
{
    use UploadFiles;

    public function index()
    {
        return view("admin.facilities.index");
    }

    public function grid()
    {
        $query = Facility::query();
        return DataTables::of($query)
            ->addColumn("name_en", function ($record) {
                $name = json_decode($record->name, true);
                return $name['en'];
            })
            ->addColumn("name_ar", function ($record) {
                $name = json_decode($record->name, true);
                return $name['ar'];
            })
            ->addColumn("actions", function ($record) {
                $edit_link = route("facilities.edit", $record->id);
                $delete_link = route("facilities.destroy", $record->id);
                $actions = "
                    <a href='$edit_link' class='badge bg-warning'>Edit</a>
                    <a href='$delete_link' class='badge bg-danger'>Delete</a>
                ";
                return $actions;
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.facilities.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name.en" => "required",
            "name.ar" => "required",
            "icon" => "required",
        ]);

        $logo = $this->uploadFile($request->icon, 'Facility', 'icon', 'image', 'facility_files');

        Facility::create([
            "name" => json_encode($request->name),
            "icon" => $logo,
        ]);

        return redirect(route("facilities.index"))->with("success_message", "facility has been stored successfully.");
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
        $details = Facility::find($id);
        $details->name = json_decode($details->name, true);
        return view("admin.facilities.edit", compact("details"));
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
        $this->validate($request, [
            "name.en" => "required",
            "name.ar" => "required",
        ]);

        $facility = Facility::find($id);

        $icon = $facility->icon;
        if ($request->icon) {
            $icon = $this->uploadFile($request->icon, 'Facility', 'icon', 'image', 'facility_files');
        }

        $facility->update([
            "name" => json_encode($request->name),
            "icon" => $icon,
        ]);

        return redirect(route("facilities.index"))->with("success_message", "facility has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $facility = Facility::find($id);
        $facility->delete();

        return redirect(route("facilities.index"))->with("success_message", "facility has been deleted successfully.");
    }
}
