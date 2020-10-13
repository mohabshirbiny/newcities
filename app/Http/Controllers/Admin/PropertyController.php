<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Compound;
use App\Developer;
use App\Http\Controllers\Controller;
use App\Property;
use App\PropertyItem;
use App\PropertyType;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PropertyController extends Controller
{
    use UploadFiles;

    public function index()
    {
        return view("admin.properties.index");
    }

    public function grid()
    {
        $query = Property::query();
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
                $link = route("properties.gallery", $record->id);
                return "<a href='$link'>Gellery</a>";
            })
            ->addColumn("attachments", function ($record) {
                $link = route("properties.attachments", $record->id);
                return "<a href='$link'>Attachments</a>";
            })
            ->addColumn("actions", function ($record) {
                $items_link = route("properties.items", $record->id);
                $edit_link = route("properties.edit", $record->id);
                $delete_link = route("properties.destroy", $record->id);
                $actions = "
                    <a href='$items_link' class='badge bg-info'>Item</a>
                    <a href='$edit_link' class='badge bg-warning'>Edit</a>
                    <a href='$delete_link' class='badge bg-danger'>Delete</a>
                ";
                return $actions;
            })
            ->rawColumns(['actions', "gallery", "attachments"])->make(true);
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
        $compounds = Compound::get();
        $property_types = PropertyType::get();
        return view("admin.properties.create", compact("cities", "developers", "compounds", "property_types"));
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
            "about.en" => "required",
            "about.ar" => "required",
            "cover" => "required",
        ]);

        $cover = $this->uploadFile($request->cover, 'Property', 'cover', 'image', 'property_files');

        $property = Property::create([
            "city_id" => $request->city_id,
            "use_facilities" => $request->use_facilities,
            "developer_id" => $request->developer_id,
            "property_type_id" => $request->property_type_id,
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "cover" => $cover,
        ]);

        return redirect(route("properties.index"))->with("success_message", "Property has been stored successfully.");
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
        $details = Property::find($id);
        $details->social_media = json_decode($details->social_media, true);
        $details->name = json_decode($details->name, true);
        $details->about = json_decode($details->about, true);
        $details->contact_details = json_decode($details->contact_details, true);
        $cities = City::select("id", "name_ar", "name_en")->get();
        $developers = Developer::get();
        $compounds = Compound::get();
        $property_items = PropertyItem::get();
        $property_types = PropertyType::get();
        return view("admin.properties.edit", compact('id', "details", "cities", "developers", "compounds", "property_items"));
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

        $property = Property::find($id);

        $logo = $property->logo;
        if ($request->logo) {
            $logo = $this->uploadFile($request->logo, 'Property', 'logo', 'image', 'property_files');
        }

        $cover = $property->cover;
        if ($request->cover) {
            $cover = $this->uploadFile($request->cover, 'Property', 'cover', 'image', 'property_files');
        }

        $property->update([
            "name" => json_encode($request->name),
            "about" => json_encode($request->about),
            "location_url" => $request->location_url,
            "social_media" => json_encode($request->social_media),
            "contact_details" => json_encode($request->contact_details),
            "logo" => $logo,
            "cover" => $cover,
        ]);

        // DB::table('property_item')->where("property_id", $id)->delete();
        // foreach ($request->items as $one_item) {
        //     DB::table('property_item')->insert([
        //         "property_id" => $id,
        //         "property_item_id" => $one_item,
        //     ]);
        // }

        return redirect(route("properties.index"))->with("success_message", "Property has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = Property::find($id);
        $property->delete();

        return redirect(route("properties.index"))->with("success_message", "Property has been deleted successfully.");
    }

    public function gallery($property_id)
    {
        $property = Property::find($property_id);
        $gallery = $property->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }

        return view("admin.properties.gallery.index", compact("property_id", "gallery_decoded"));
    }

    public function createGallery($property_id)
    {
        return view("admin.properties.gallery.create", compact("property_id"));
    }

    public function storeGallery(Request $request, $property_id)
    {
        $property = Property::find($property_id);

        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'Compound', 'gallery', $request->file_type, 'property_files');
        } else {
            $uploaded_gallery = $request->gallery;
        }

        $gallery = $property->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        } else {
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $property->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("properties.gallery", $property))->with("success_message", "Property gallery has been stored successfully.");
    }

    public function deleteGallery($property_id, $file_name)
    {
        $property = Property::find($property_id);

        $gallery = $property->gallery;
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
            $property->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("properties.gallery", $property))->with("success_message", "Property gallery has been deleted successfully.");
        }
        return redirect(route("properties.gallery", $property))->with("success_message", "Property gallery has been deleted successfully.");
    }


    public function attachments($property_id)
    {
        $property = Property::find($property_id);
        $attachments = $property->attachments;
        $attachments_decoded = [];
        if ($attachments) {
            $attachments_decoded = json_decode($attachments, true);
        }

        return view("admin.properties.attachments.index", compact("property_id", "attachments_decoded"));
    }

    public function createAttachments($property_id)
    {
        return view("admin.properties.attachments.create", compact("property_id"));
    }

    public function storeAttachments(Request $request, $property_id)
    {
        $property = Property::find($property_id);

        $uploaded_attachments = $this->uploadFile($request->attachments, 'Property', 'attachments', 'file', 'property_files');

        $attachments = $property->attachments;
        $attachments_decoded = [];
        if ($attachments) {
            $attachments_decoded = json_decode($attachments, true);
            $attachments_decoded['file'][] = $uploaded_attachments;
        } else {
            $attachments_decoded['file'][] = $uploaded_attachments;
        }

        $property->update([
            "attachments" => json_encode($attachments_decoded),
        ]);

        return redirect(route("properties.attachments", $property))->with("success_message", "property attachments has been stored successfully.");
    }

    public function deleteAttachments($property_id, $file_name)
    {
        $property = Property::find($property_id);

        $attachments = $property->attachments;
        if ($attachments) {
            $new_attachments = [];
            $attachments_decoded = json_decode($attachments, true);
            foreach ($attachments_decoded as $type => $one_arr) {
                foreach ($one_arr as $one_value) {
                    if ($one_value != $file_name) {
                        $new_attachments['file'][] = $one_value;
                    }
                }
            }
            $property->update([
                "attachments" => json_encode($new_attachments),
            ]);

            return redirect(route("properties.attachments", $property))->with("success_message", "property attachments has been deleted successfully.");
        }
        return redirect(route("properties.attachments", $property))->with("success_message", "property attachments has been deleted successfully.");
    }

    public function items($property_id)
    {
        $items_count = DB::table('property_item')->where("property_id", $property_id)->pluck("count_of_items", "property_item_id")->toArray();
        $items_ids = array_keys($items_count);
        $property_items = PropertyItem::whereIn("id", $items_ids)->get();
        return view("admin.properties.items.index", compact("property_items", "property_id", "items_count"));
    }

    public function deleteItem($property_id, $item_id)
    {
        DB::table('property_item')->where("property_id", $property_id)
            ->where("property_item_id", $item_id)->delete();
        return redirect(route("properties.items", $property_id))->with("success_message", "Item has been deleted successfully.");
    }

    public function addItem($property_id)
    {
        $items_ids = DB::table('property_item')->where("property_id", $property_id)->pluck("property_item_id")->toArray();
        $property_items = PropertyItem::whereNotIn("id", $items_ids)->get();
        return view("admin.properties.items.create", compact("property_items", "property_id"));
    }

    public function storeItem(Request $request)
    {
        DB::table('property_item')->insert([
            "property_id" => $request->property_id,
            "property_item_id" => $request->property_item_id,
            "count_of_items" => $request->count_of_items,
        ]);

        return redirect(route("properties.items", $request->property_id))->with("success_message", "Item has been added successfully.");
    }
}
