<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Contractor;
use App\Developer;
use App\EventSponsor;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
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
            
            $query = City::query();                                        
            
            return DataTables::of($query)
                ->addColumn("gallery", function ($record) {
                    $link = route("cities.gallery", $record->id);
                    return "<a href='$link'>Gellery</a>";
                })
                ->addColumn("actions", function($record) {
                    $edit_link = route("cities.edit", $record->id);
                    $delete_link = route("cities.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions','gallery'])->make(true);
        } else {
            return view("admin.cities.index");
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $developers = Developer::get();
        $contractors = Contractor::get();
        $sponsors = EventSponsor::get();
        return view("admin.cities.create",compact('developers','contractors','sponsors'));
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
            "name_ar" => "required|string",
            "name_en" => "required|string",
            "cover" => "required",
            "logo" => "required",
            "about_ar" => "required",
            "about_en" => "required",
            "contact_details" => "required",
            "social_links" => "required",
        ]);

        $requestData = $request->except(['logo' , 'cover']);
        
        // send files to rename and upload
        $logo = $this->uploadFile($request->logo , 'City','logo','image','city_files');
        $cover = $this->uploadFile($request->cover , 'City','cover','image','city_files');

        $cityData = [

            'cover'  => $cover,
            'logo'  => $logo,
            'contact_details'  => serialize($request->contact_details ),
            'social_links'     => serialize($request->social_links ),
        ];
        
        $cityData = array_merge($requestData , $cityData);
            // dd($cityData);
        $city = City::create($cityData);

        if ($request->developers) {
            $city->developers()->attach($request->developers);
        }

        if ($request->contractors) {
            $city->contractors()->attach($request->contractors);
        }

        if ($request->sponsors) {
            $city->sponsors()->attach($request->sponsors);
        }

        return redirect()->route('cities.index')->withSuccess( 'تم انشاء المدينة بنجاح !');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('d');
        return redirect()->route('cities.index')->withSuccess( 'تم انشاء المدينة بنجاح !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::findorfail($id);
        $developers = Developer::get();
        $city_developers = $city->developers->pluck('id')->toArray();
        $contractors = Contractor::get();
        $sponsors = EventSponsor::get();
        $city_contractors = $city->contractors->pluck('id')->toArray();
        $city_sponsors = $city->sponsors->pluck('id')->toArray();
        // dd($city->developers->pluck('id')->toArray());
        return view("admin.cities.edit", compact("city",'developers','contractors','city_developers','city_contractors','sponsors','city_sponsors'));
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
        $city = City::findorfail($id);
        
        $this->validate($request, [
            "name_ar"           => "required|string",
            "name_en"           => "required|string",
            // "cover"             => "file|max:10000",
            // "logo"              => "file|max:10000",
            "about_ar"          => "required",
            "about_en"          => "required",
            "contact_details"   => "required",
            "social_links"      => "required",
            "location_url"      => "required",
        ]);

        $requestData = $request->except(['logo' , 'cover','_token','_method']);
        $cityData =[];
        
        // send files to rename and upload
        if ($request->logo) { 
            $logo = $this->uploadFile($request->logo , 'City','logo','image','city_files');
            $cityData['logo'] = $logo;
        }

        if ($request->cover) {
            $cover = $this->uploadFile($request->cover , 'City','cover','image','city_files');
            $cityData['cover'] = $cover;
        }

        $city->developers()->sync($request->developers);

        $city->contractors()->sync($request->contractors);

        $city->sponsors()->sync($request->sponsors);
        
        $cityData = array_merge($cityData,[
            'contact_details'  => serialize($request->contact_details ),
            'social_links'     => serialize($request->social_links ),
        ]);
// dd($request->all(),$cityData);
        $cityData = array_merge($requestData , $cityData);

        $city->update($cityData);
        // dd($city,$cityData);
        return redirect()->back()->withSuccess( 'the city was updated successfully') ;
        
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

    public function gallery($city_id)
    {
        $city = City::findOrfail($city_id);
        $gallery = $city->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }
        
        return view("admin.cities.gallery.index", compact("city_id", "gallery_decoded"));
    }

    public function createGallery($city_id)
    {
        return view("admin.cities.gallery.create", compact("city_id"));
    }

    public function storeGallery(Request $request, $city_id)
    {
        $city = City::findOrfail($city_id);

        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'City', 'gallery', $request->file_type, 'city_files');
        } else {
            $uploaded_gallery = $request->gallery;
        }

        $gallery = $city->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        } else {
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $city->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("cities.gallery", $city))->with("success_message", "city gallery has been stored successfully.");
    }

    public function deleteGallery($city_id, $file_name)
    {
        $city = City::findOrfail($city_id);

        $gallery = $city->gallery;
        if ($gallery) {
            $new_gallery = [];
            $gallery_decoded = json_decode($gallery, true);
            foreach ($gallery_decoded as $type => $one_arr) {
                foreach ($one_arr as $one_value) {
                    if ($one_value != $file_name) {
                        $new_gallery[$type][] = $file_name;
                    }
                }
            }
            $city->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("cities.gallery", $city))->with("success_message", "city gallery has been deleted successfully.");
        }
        return redirect(route("cities.gallery", $city))->with("success_message", "city gallery has been deleted successfully.");
    }
}
