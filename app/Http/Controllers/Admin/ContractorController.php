<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contractor;
use App\ContractorCategory;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContractorController extends Controller
{
    use UploadFiles;

    public function index()
    {
        return view("admin.contractors.index");
    }

    public function grid()
    {
        $query = Contractor::query();
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
                $link = route("contractors.gallery", $record->id);
                return "<a href='$link'>Gellery</a>";
            })
            ->addColumn("actions", function ($record) {
                $edit_link = route("contractors.edit", $record->id);
                $delete_link = route("contractors.destroy", $record->id);
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
        $categories = ContractorCategory::get();
        return view("admin.contractors.create", compact("categories"));
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
            "contractor_category_id" => "required",
            "name.en" => "required",
            "name.ar" => "required",
            "logo" => "required",
            "about.en" => "required",
            "about.ar" => "required",
        ]);

        $logo = $this->uploadFile($request->logo, 'Contractor', 'logo', 'image', 'contractor_files');
        $cover = $this->uploadFile($request->cover, 'Contractor', 'cover', 'image', 'contractor_files');

        Contractor::create([
            "contractor_category_id" => $request->contractor_category_id,
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "location_url" => $request->location_url,
            "social_media" => json_encode($request->social_media),
            "contact_details" => json_encode($request->contact_details),
            "logo" => $logo,
            "cover" => $cover,
        ]);

        return redirect(route("contractors.index"))->with("success_message", "Contractor has been stored successfully.");
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
        $details = Contractor::find($id);
        $details->social_media = json_decode($details->social_media, true);
        $details->name = json_decode($details->name, true);
        $details->about = json_decode($details->about, true);
        $details->contact_details = json_decode($details->contact_details, true);
        $categories = ContractorCategory::get();
        return view("admin.contractors.edit", compact("id", "categories", "details"));
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
            "contractor_category_id" => "required",
            "name.en" => "required",
            "name.ar" => "required",
            "about.en" => "required",
            "about.ar" => "required",
        ]);

        $contractor = Contractor::find($id);

        $logo = $contractor->logo;
        if ($request->logo) {
            $logo = $this->uploadFile($request->logo, 'Contractor', 'logo', 'image', 'contractor_files');
        }

        $cover = $contractor->cover;
        if ($request->cover) {
            $cover = $this->uploadFile($request->cover, 'Contractor', 'cover', 'image', 'contractor_files');
        }

        $contractor->update([
            "contractor_category_id" => $request->contractor_category_id,
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "location_url" => $request->location_url,
            "social_media" => json_encode($request->social_media),
            "contact_details" => json_encode($request->contact_details),
            "logo" => $logo,
            "cover" => $cover,
        ]);

        return redirect(route("contractors.index"))->with("success_message", "vendor has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contractor = Contractor::find($id);
        $contractor->delete();

        return redirect(route("contractors.index"))->with("success_message", "Contractor has been deleted successfully.");
    }

    public function gallery($contractor_id)
    {
        $contractor = Contractor::find($contractor_id);
        $gallery = $contractor->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }

        return view("admin.contractors.gallery.index", compact("contractor_id", "gallery_decoded"));
    }

    public function createGallery($contractor_id)
    {
        return view("admin.contractors.gallery.create", compact("contractor_id"));
    }

    public function storeGallery(Request $request, $contractor_id)
    {
        $contractor = Contractor::find($contractor_id);

        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'Contractor', 'gallery', $request->file_type, 'contractor_files');
        } else {
            $uploaded_gallery = $request->gallery;
        }

        $gallery = $contractor->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        } else {
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $contractor->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("contractors.gallery", $contractor))->with("success_message", "Contractor gallery has been stored successfully.");
    }

    public function deleteGallery($contractor_id, $file_name)
    {
        $contractor = Contractor::find($contractor_id);

        $gallery = $contractor->gallery;
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
            $contractor->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("contractors.gallery", $contractor))->with("success_message", "Contractor gallery has been deleted successfully.");
        }
        return redirect(route("contractors.gallery", $contractor))->with("success_message", "Contractor gallery has been deleted successfully.");
    }
}
