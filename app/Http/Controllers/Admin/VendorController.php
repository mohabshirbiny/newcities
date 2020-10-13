<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use App\Vendor;
use App\VendorCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    use UploadFiles;

    public function index()
    {
        return view("admin.vendors.index");
    }

    public function grid()
    {
        $query = Vendor::query();
        return DataTables::of($query)
            ->addColumn("name_en", function ($record) {
                $name = json_decode($record->name, true);
                return $name['en'];
            })
            ->addColumn("name_ar", function ($record) {
                $name = json_decode($record->name, true);
                return $name['ar'];
            })
            ->addColumn("gallery", function ($record) {
                $link = route("vendors.gallery", $record->id);
                return "<a href='$link'>Gellery</a>";
            })
            ->addColumn("actions", function ($record) {
                $edit_link = route("vendors.edit", $record->id);
                $delete_link = route("vendors.destroy", $record->id);
                $actions = "
                    <a href='$edit_link' class='badge bg-warning'>Edit</a>
                    <a href='$delete_link' class='badge bg-danger'>Delete</a>
                ";
                return $actions;
            })
            ->rawColumns(['actions', "gallery"])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = VendorCategory::get();
        $cities = City::select("id", "name_ar", "name_en")->get();
        $vendors = Vendor::select("id", "name")->get();
        return view("admin.vendors.create", compact("categories", "cities", "vendors"));
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
            "vendor_category_id" => "required",
            "is_parent" => "required",
            "city_id" => "required",
            "name.en" => "required",
            "name.ar" => "required",
            "logo" => "required",
            "about.en" => "required",
            "about.ar" => "required",
            "location_url" => "required",
            "cover" => "required",
        ]);

        $logo = $this->uploadFile($request->logo, 'Vendor', 'logo', 'image', 'vendor_files');
        $cover = $this->uploadFile($request->cover, 'Vendor', 'cover', 'image', 'vendor_files');

        Vendor::create([
            "vendor_category_id" => $request->vendor_category_id,
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "location_url" => $request->location_url,
            "social_media" => json_encode($request->social_media),
            "contact_details" => json_encode($request->contact_details),
            "is_parent" => $request->is_parent ,
            "parent_id" => ($request->is_parent == 1) ? null : $request->parent_id,
            "city_id" => $request->city_id,
            "destrict_id" => $request->destrict_id,
            "logo" => $logo,
            "cover" => $cover,
        ]);

        return redirect(route("vendors.index"))->with("success_message", "vendor has been stored successfully.");
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
        $details = Vendor::find($id);
        $details->social_media = json_decode($details->social_media, true);
        $details->name = json_decode($details->name, true);
        $details->about = json_decode($details->about, true);
        $details->contact_details = json_decode($details->contact_details, true);
        $categories = VendorCategory::get();
        $cities = City::select("id", "name_ar", "name_en")->get();
        $vendors = Vendor::where("id", "<>", $id)->select("id", "name")->get();
        return view("admin.vendors.edit", compact('id', "details", "categories", "cities", "vendors"));
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
            "vendor_category_id" => "required",
            "name.en" => "required",
            "name.ar" => "required",
            "about.en" => "required",
            "about.ar" => "required",
            "location_url" => "required",
        ]);

        $vendor = Vendor::find($id);

        $logo = $vendor->logo;
        if ($request->logo) {
            $logo = $this->uploadFile($request->logo, 'Vendor', 'logo', 'image', 'vendor_files');
        }

        $cover = $vendor->cover;
        if ($request->cover) {
            $cover = $this->uploadFile($request->cover, 'Vendor', 'cover', 'image', 'vendor_files');
        }

        $vendor->update([
            "vendor_category_id" => $request->vendor_category_id,
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "location_url" => $request->location_url,
            "social_media" => json_encode($request->social_media),
            "contact_details" => json_encode($request->contact_details),
            "is_parent" => $request->is_parent ,
            "parent_id" => ($request->is_parent == 1) ? null : $request->parent_id,
            "city_id" => $request->city_id,
            "destrict_id" => $request->destrict_id,
            "logo" => $logo,
            "cover" => $cover,
        ]);

        return redirect(route("vendors.index"))->with("success_message", "vendor has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        $vendor->delete();

        return redirect(route("vendors.index"))->with("success_message", "vendor has been deleted successfully.");
    }

    public function gallery($vendor_id)
    {
        $vendor = Vendor::find($vendor_id);
        $gallery = $vendor->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }

        return view("admin.vendors.gallery.index", compact("vendor_id", "gallery_decoded"));
    }

    public function createGallery($vendor_id)
    {
        return view("admin.vendors.gallery.create", compact("vendor_id"));
    }

    public function storeGallery(Request $request, $vendor_id)
    {
        $vendor = Vendor::find($vendor_id);

        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'Vendor', 'gallery', $request->file_type, 'vendor_files');
        } else {
            $uploaded_gallery = $request->gallery;
        }

        $gallery = $vendor->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        } else {
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $vendor->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("vendors.gallery", $vendor))->with("success_message", "vendor gallery has been stored successfully.");
    }

    public function deleteGallery($vendor_id, $file_name)
    {
        $vendor = Vendor::find($vendor_id);

        $gallery = $vendor->gallery;
        if ($gallery) {
            $new_gallery = [];
            $gallery_decoded = json_decode($gallery, true);
            foreach ($gallery_decoded as $type => $one_arr) {
                foreach ($one_arr as $one_value) {
                    if ($one_value != $file_name) {
                        $new_gallery[$type][] = $one_value;
                    }
                }
            }
            $vendor->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("vendors.gallery", $vendor))->with("success_message", "vendor gallery has been deleted successfully.");
        }
        return redirect(route("vendors.gallery", $vendor))->with("success_message", "vendor gallery has been deleted successfully.");
    }
}
