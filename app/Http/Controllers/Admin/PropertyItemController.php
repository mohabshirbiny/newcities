<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PropertyItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\UploadFiles;

class PropertyItemController extends Controller
{
    use UploadFiles;

    public function index()
    {
        return view("admin.property_items.index");
    }

    public function grid()
    {
        $query = PropertyItem::query();
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
                $edit_link = route("property-items.edit", $record->id);
                $delete_link = route("property-items.destroy", $record->id);
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
        return view("admin.property_items.create");
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

        $logo = $this->uploadFile($request->icon, 'PropertyItem', 'icon', 'image', 'property_files');

        PropertyItem::create([
            "name" => json_encode($request->name),
            "icon" => $logo,
        ]);

        return redirect(route("property-items.index"))->with("success_message", "property item has been stored successfully.");
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
        $details = PropertyItem::find($id);
        $details->name = json_decode($details->name, true);
        return view("admin.property_items.edit", compact("details"));
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
            "name_en" => "required",
            "name_ar" => "required",
            "icon" => "required",
        ]);

        $name = ["name_en" => $request->name_en, "name_ar" => $request->name_ar];

        $property_item = PropertyItem::find($id);

        $property_item->update([
            "name" => $name,
            "icon" => $request->icon,
        ]);

        return redirect(route("property-items.index"))->with("success_message", "property item has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property_item = PropertyItem::find($id);
        $property_item->delete();

        return redirect(route("property-items.index"))->with("success_message", "property item has been deleted successfully.");
    }
}
