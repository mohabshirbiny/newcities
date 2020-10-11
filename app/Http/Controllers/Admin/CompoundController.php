<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Compound;
use App\Contractor;
use App\Developer;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CompoundController extends Controller
{
    use UploadFiles;

    public function index()
    {
        return view("admin.compounds.index");
    }

    public function grid()
    {
        $query = Compound::query();
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
                $link = route("compounds.gallery", $record->id);
                return "<a href='$link'>Gellery</a>";
            })
            ->addColumn("actions", function ($record) {
                $edit_link = route("compounds.edit", $record->id);
                $delete_link = route("compounds.destroy", $record->id);
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
        $cities = City::select("id", "name_ar", "name_en")->get();
        $developers = Developer::get();
        $contractors = Contractor::get();
        return view("admin.compounds.create", compact("cities", "developers", "contractors"));
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
            "city_id" => "required",
            "name.en" => "required",
            "name.ar" => "required",
            "logo" => "required",
            "about.en" => "required",
            "about.ar" => "required",
            "location_url" => "required",
            "cover" => "required",
        ]);

        $logo = $this->uploadFile($request->logo, 'Compound', 'logo', 'image', 'compound_files');
        $cover = $this->uploadFile($request->cover, 'Compound', 'cover', 'image', 'compound_files');

        $compound = Compound::create([
            "city_id" => $request->city_id,
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "location_url" => $request->location_url,
            "social_media" => json_encode($request->social_media),
            "contact_details" => json_encode($request->contact_details),
            "logo" => $logo,
            "cover" => $cover,
        ]);

        if($request->developers){
            foreach($request->developers as $one_developer) {
                        DB::table('compound_developer')->insert([
                            "compound_id" => $compound->id,
                            "developer_id" => $one_developer
                        ]);
                    }
        }
        
        if($request->contractors){

        
        foreach($request->contractors as $one_contractor) {
            DB::table('compound_contractor')->insert([
                "compound_id" => $compound->id,
                "contractor_id" => $one_contractor
            ]);
        }
        }

        return redirect(route("compounds.index"))->with("success_message", "Compound has been stored successfully.");
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
        $details = Compound::find($id);
        $details->social_media = json_decode($details->social_media, true);
        $details->name = json_decode($details->name, true);
        $details->about = json_decode($details->about, true);
        $details->contact_details = json_decode($details->contact_details, true);
        $cities = City::select("id", "name_ar", "name_en")->get();
        $data['developers'] = Developer::get();
        $data['selected_developers'] = DB::table('compound_developer')->where("compound_id", $id)->pluck("developer_id")->toArray();
        $data['contractors'] = Contractor::get();
        $data['selected_contractors'] = DB::table('compound_contractor')->where("compound_id", $id)->pluck("contractor_id")->toArray();
        return view("admin.compounds.edit", compact('id', "details", "cities", "data"));
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

        $compound = Compound::find($id);

        $logo = $compound->logo;
        if ($request->logo) {
            $logo = $this->uploadFile($request->logo, 'Compound', 'logo', 'image', 'compound_files');
        }

        $cover = $compound->cover;
        if ($request->cover) {
            $cover = $this->uploadFile($request->cover, 'Compound', 'cover', 'image', 'compound_files');
        }

        $compound->update([
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "location_url" => $request->location_url,
            "social_media" => json_encode($request->social_media),
            "contact_details" => json_encode($request->contact_details),
            "logo" => $logo,
            "cover" => $cover,
        ]);

        DB::table('compound_developer')->where("compound_id", $id)->delete();
        foreach($request->developers as $one_developer) {
            DB::table('compound_developer')->insert([
                "compound_id" => $id,
                "developer_id" => $one_developer
            ]);
        }

        DB::table('compound_contractor')->where("compound_id", $id)->delete();
        foreach($request->contractors as $one_contractor) {
            DB::table('compound_contractor')->insert([
                "compound_id" => $id,
                "contractor_id" => $one_contractor
            ]);
        }

        return redirect(route("compounds.index"))->with("success_message", "Compound has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $compound = Compound::find($id);
        $compound->delete();

        return redirect(route("compounds.index"))->with("success_message", "Compound has been deleted successfully.");
    }

    public function gallery($compound_id)
    {
        $compound = Compound::find($compound_id);
        $gallery = $compound->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }

        return view("admin.compounds.gallery.index", compact("compound_id", "gallery_decoded"));
    }

    public function createGallery($compound_id)
    {
        return view("admin.compounds.gallery.create", compact("compound_id"));
    }

    public function storeGallery(Request $request, $compound_id)
    {
        $compound = Compound::find($compound_id);

        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'Compound', 'gallery', $request->file_type, 'compound_files');
        } else {
            $uploaded_gallery = $request->gallery;
        }

        $gallery = $compound->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        } else {
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $compound->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("compounds.gallery", $compound))->with("success_message", "Compound gallery has been stored successfully.");
    }

    public function deleteGallery($compound_id, $file_name)
    {
        $compound = Compound::find($compound_id);

        $gallery = $compound->gallery;
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
            $compound->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("compounds.gallery", $compound))->with("success_message", "Compound gallery has been deleted successfully.");
        }
        return redirect(route("compounds.gallery", $compound))->with("success_message", "Compound gallery has been deleted successfully.");
    }
}
