<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\VendorCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\UploadFiles;

class VendorCategoryController extends Controller
{
    use UploadFiles;

    public function index()
    {
        return view("admin.vendor_categories.index");
    }

    public function grid()
    {
        $query = VendorCategory::query();
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
                $edit_link = route("vendor-categories.edit", $record->id);
                $delete_link = route("vendor-categories.destroy", $record->id);
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
        $categories = VendorCategory::all();
        // dd($categories);
        return view("admin.vendor_categories.create",compact('categories'));
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

        $logo = $this->uploadFile($request->icon, 'VendorCategory', 'icon', 'image', 'vendor_category_files');

        VendorCategory::create([
            "name" => json_encode($request->name),
            "parent_id" => $request->parent_id,
            "icon" => $logo,
        ]);

        return redirect(route("vendor-categories.index"))->with("success_message", "vendor category has been stored successfully.");
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
        $vendorCategory  = VendorCategory::find($id);
        $categories = VendorCategory::all();
        return view("admin.vendor_categories.edit", compact("vendorCategory",'categories'));
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
            "icon" => "image",
        ]);

        $name = ["name_en" => $request->name_en, "name_ar" => $request->name_ar];

        $vendor_category = VendorCategory::find($id);

        if ($request->icon) {
            $data['icon'] = $this->uploadFile($request->icon, 'Vendor', 'icon', 'image', 'vendor_category_files');
        }else{
            $data['icon'] = $vendor_category->icon;
        }

        if ($request->parent_id) {
            $data['parent_id'] = $request->parent_id;
        }else{
            $data['parent_id'] = null;
        }

        $data = array_merge($data,[
            "name" => json_encode($request->name),
        ]);

        $vendor_category->update($data);

        return redirect(route("vendor-categories.index"))->with("success_message", "vendor category has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor_category = VendorCategory::find($id);
        $vendor_category->delete();

        return redirect(route("vendor-categories.index"))->with("success_message", "Vendor category has been deleted successfully.");
    }
}