<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service;
use App\ServiceCategory;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    use UploadFiles;

    public function index()
    {
        return view("admin.services.index");
    }

    public function grid()
    {
        $query = Service::query();
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
                $link = route("services.gallery", $record->id);
                return "<a href='$link'>Gellery</a>";
            })
            ->addColumn("actions", function ($record) {
                $edit_link = route("services.edit", $record->id);
                $delete_link = route("services.destroy", $record->id);
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
        $categories = ServiceCategory::get();
        return view("admin.services.create", compact("categories"));
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
            "service_category_id" => "required",
            "name.en" => "required",
            "name.ar" => "required",
            "logo" => "required",
            "about.en" => "required",
            "about.ar" => "required",
        ]);

        $logo = $this->uploadFile($request->logo, 'Service', 'logo', 'image', 'service_files');
        $cover = $this->uploadFile($request->cover, 'Service', 'cover', 'image', 'service_files');

        Service::create([
            "service_category_id" => $request->service_category_id,
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "location_url" => $request->location_url,
            "social_media" => json_encode($request->social_media),
            "contact_details" => json_encode($request->contact_details),
            "logo" => $logo,
            "cover" => $cover,
        ]);

        return redirect(route("services.index"))->with("success_message", "Service has been stored successfully.");
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
        $details = Service::find($id);
        $details->social_media = json_decode($details->social_media, true);
        $details->name = json_decode($details->name, true);
        $details->about = json_decode($details->about, true);
        $details->contact_details = json_decode($details->contact_details, true);
        $categories = ServiceCategory::get();
        return view("admin.services.edit", compact("id", "categories", "details"));
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
            "service_category_id" => "required",
            "name.en" => "required",
            "name.ar" => "required",
            "about.en" => "required",
            "about.ar" => "required",
        ]);

        $service = Service::find($id);

        $logo = $service->logo;
        if ($request->logo) {
            $logo = $this->uploadFile($request->logo, 'Service', 'logo', 'image', 'service_files');
        }

        $cover = $service->cover;
        if ($request->cover) {
            $cover = $this->uploadFile($request->cover, 'Service', 'cover', 'image', 'service_files');
        }

        $service->update([
            "service_category_id" => $request->service_category_id,
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "location_url" => $request->location_url,
            "social_media" => json_encode($request->social_media),
            "contact_details" => json_encode($request->contact_details),
            "logo" => $logo,
            "cover" => $cover,
        ]);

        return redirect(route("services.index"))->with("success_message", "vendor has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        $service->delete();

        return redirect(route("services.index"))->with("success_message", "Service has been deleted successfully.");
    }

    public function gallery($service_id)
    {
        $service = Service::find($service_id);
        $gallery = $service->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }

        return view("admin.services.gallery.index", compact("service_id", "gallery_decoded"));
    }

    public function createGallery($service_id)
    {
        return view("admin.services.gallery.create", compact("service_id"));
    }

    public function storeGallery(Request $request, $service_id)
    {
        $service = Service::find($service_id);

        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'Service', 'gallery', $request->file_type, 'service_files');
        } else {
            $uploaded_gallery = $request->gallery;
        }

        $gallery = $service->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        } else {
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $service->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("services.gallery", $service))->with("success_message", "Service gallery has been stored successfully.");
    }

    public function deleteGallery($service_id, $file_name)
    {
        $service = Service::find($service_id);

        $gallery = $service->gallery;
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
            $service->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("services.gallery", $service))->with("success_message", "Service gallery has been deleted successfully.");
        }
        return redirect(route("services.gallery", $service))->with("success_message", "Service gallery has been deleted successfully.");
    }
}
