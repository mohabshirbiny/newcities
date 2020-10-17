<?php

namespace App\Http\Controllers\Admin;

use App\Developer;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DeveloperController extends Controller
{
    use UploadFiles;

    public function index()
    {
        return view("admin.developers.index");
    }

    public function grid()
    {
        $query = Developer::query();
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
                $link = route("developers.gallery", $record->id);
                return "<a href='$link'>Gellery</a>";
            })
            ->addColumn("actions", function ($record) {
                $edit_link = route("developers.edit", $record->id);
                $delete_link = route("developers.destroy", $record->id);
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
        return view("admin.developers.create");
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
            "logo" => "required",
            "about.en" => "required",
            "about.ar" => "required",
            "location_url" => "required",
            "cover" => "required",
        ]);

        $logo = $this->uploadFile($request->logo, 'Developer', 'logo', 'image', 'developer_files');
        $cover = $this->uploadFile($request->cover, 'Developer', 'cover', 'image', 'developer_files');

        Developer::create([
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "location_url" => $request->location_url,
            "social_media" => json_encode($request->social_media),
            "contact_details" => json_encode($request->contact_details),
            "logo" => $logo,
            "cover" => $cover,
        ]);

        return redirect(route("developers.index"))->with("success_message", "developer has been stored successfully.");
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
        $details = Developer::find($id);
        $details->social_media = json_decode($details->social_media, true);
        $details->name = json_decode($details->name, true);
        $details->about = json_decode($details->about, true);
        // $details->contact_details = json_decode($details->contact_details, true);
        return view("admin.developers.edit", compact('id', "details"));
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
            "about.en" => "required",
            "about.ar" => "required",
            "location_url" => "required",
        ]);

        $developer = Developer::find($id);

        $logo = $developer->logo;
        if ($request->logo) {
            $logo = $this->uploadFile($request->logo, 'Developer', 'logo', 'image', 'developer_files');
        }

        $cover = $developer->cover;
        if ($request->cover) {
            $cover = $this->uploadFile($request->cover, 'Developer', 'cover', 'image', 'developer_files');
        }

        $developer->update([
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "location_url" => $request->location_url,
            "social_media" => json_encode($request->social_media),
            "contact_details" => json_encode($request->contact_details),
            "logo" => $logo,
            "cover" => $cover,
        ]);

        return redirect(route("developers.index"))->with("success_message", "developer has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $developer = Developer::find($id);
        $developer->delete();

        return redirect(route("developers.index"))->with("success_message", "Developer has been deleted successfully.");
    }

    public function gallery($developer_id)
    {
        $developer = Developer::find($developer_id);
        $gallery = $developer->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }

        return view("admin.developers.gallery.index", compact("developer_id", "gallery_decoded"));
    }

    public function createGallery($developer_id)
    {
        return view("admin.developers.gallery.create", compact("developer_id"));
    }

    public function storeGallery(Request $request, $developer_id)
    {
        $developer = Developer::find($developer_id);

        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'Developer', 'gallery', $request->file_type, 'developer_files');
        } else {
            $uploaded_gallery = $request->gallery;
        }

        $gallery = $developer->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        } else {
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $developer->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("developers.gallery", $developer))->with("success_message", "Developer gallery has been stored successfully.");
    }

    public function deleteGallery($developer_id, $file_name)
    {
        $developer = Developer::find($developer_id);

        $gallery = $developer->gallery;
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
            $developer->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("developers.gallery", $developer))->with("success_message", "Developer gallery has been deleted successfully.");
        }
        return redirect(route("developers.gallery", $developer))->with("success_message", "Developer gallery has been deleted successfully.");
    }
}
