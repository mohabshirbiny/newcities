<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Event;
use App\EventCategory;
use App\EventOrganizer;
use App\EventSponsor;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
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
            
            $query = Event::query();                                        
            
            return DataTables::of($query)
                ->addColumn("gallery", function ($record) {
                    $link = route("events.gallery", $record->id);
                    return "<a href='$link'>Gellery</a>";
                })
                ->addColumn("actions", function($record) {
                    $edit_link = route("events.edit", $record->id);
                    $delete_link = route("events.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions','gallery'])->make(true);
        } else {
            return view("admin.events.index");
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $EventCategories = EventCategory::all();
        $cities = City::all();                                        
        return view("admin.events.create",compact('EventCategories','cities'));
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
            "event_category_id" => "required|string",
            "city_id" => "required|string",
            "title_ar" => "required|string",
            "title_en" => "required|string",
            "cover" => "required",
            // "logo" => "required",
            "about_ar" => "required",
            "about_en" => "required",
            "contact_details" => "required",
            "social_links" => "required",
            "city_location" => "required",
            "date_from" => "required|date",
            "date_to" => "required|date",
        ]);

        $requestData = $request->except(['logo' , 'cover']);
        
        // send files to rename and upload
        // $logo = $this->uploadFile($request->logo , 'Event','logo','image','event_files');
        $cover = $this->uploadFile($request->cover , 'Event','cover','image','event_files');

        $eventData = [

            'cover'  => $cover,
            // 'logo'  => $logo,
            'contact_details'  => serialize($request->contact_details ),
            'social_links'     => serialize($request->social_links ),
        ];
        
        $eventData = array_merge($requestData , $eventData);
            // dd($eventData);
        $event = Event::create($eventData);

        return redirect()->route('events.index')->withSuccess( 'تم انشاء المدينة بنجاح !');

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
        return redirect()->route('events.index')->withSuccess( 'تم انشاء المدينة بنجاح !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findorfail($id);
        $EventCategories = EventCategory::all();
        $EventSponsors = EventSponsor::all();
        $EventOrganizers = EventOrganizer::all();
        $cities = City::all();  
        return view("admin.events.edit", compact("event",'EventCategories','cities','EventSponsors','EventOrganizers'));
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
        $event = Event::findorfail($id);

        $this->validate($request, [
            "event_category_id" => "required|string",
            "city_id" => "required|string",
            "title_ar" => "required|string",
            "title_en" => "required|string",
            "cover" => "file",
            // "logo" => "required",
            "about_ar" => "required",
            "about_en" => "required",
            "contact_details" => "required",
            "social_links" => "required",
            "city_location" => "required",
            "date_from" => "required|date",
            "date_to" => "required|date",
        ]);

        $requestData = $request->except(['logo' , 'cover','_token','_method']);
        $eventData =[];
        
        // send files to rename and upload
        if ($request->logo) { 
            $logo = $this->uploadFile($request->logo , 'Event','logo','image','event_files');
            $eventData['logo'] = $logo;
        }

        if ($request->cover) {
            $cover = $this->uploadFile($request->cover , 'Event','cover','image','event_files');
            $eventData['cover'] = $cover;
        }
        
        $eventData = array_merge($eventData,[
            'contact_details'  => serialize($request->contact_details ),
            'social_links'     => serialize($request->social_links ),
        ]);
            // dd($request->all(),$eventData);
        $eventData = array_merge($requestData , $eventData);

        $event->update($eventData);
        // dd($event,$eventData);
        return redirect()->back()->withSuccess( 'the event was updated successfully') ;
        
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

    public function gallery($event_id)
    {
        $event = Event::findOrfail($event_id);
        $gallery = $event->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }
        
        return view("admin.events.gallery.index", compact("event_id", "gallery_decoded"));
    }

    public function createGallery($event_id)
    {
        return view("admin.events.gallery.create", compact("event_id"));
    }

    public function storeGallery(Request $request, $event_id)
    {
        $event = Event::findOrfail($event_id);
        // dd($request->all());
        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'Event', 'gallery', $request->file_type, 'event_files');
            if ($request->thumbnail && $request->file_type == 'video') {
                $thumbnail = $this->uploadFile($request->thumbnail, 'Event', 'thumbnail', 'image', 'event_files');
            }
        } else {
            $uploaded_gallery = $request->gallery;
        }
        
        $gallery = $event->gallery;
        $gallery_decoded = [];
        
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);            
        }

        if ($request->file_type == 'video') {

            if(!isset($gallery_decoded['video'])){
                $i = 0;
            }else{
                $i = count($gallery_decoded['video']);
            }
            $gallery_decoded['video'][$i]['video'] = $uploaded_gallery;
            $gallery_decoded['video'][$i]['thumbnail'] = $thumbnail;
        }else{
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $event->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("events.gallery", $event))->with("success_message", "event gallery has been stored successfully.");
    }

    public function deleteGallery($event_id, $file_name)
    {
        $event = Event::findOrfail($event_id);

        $gallery = $event->gallery;
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
            $event->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("events.gallery", $event))->with("success_message", "event gallery has been deleted successfully.");
        }
        return redirect(route("events.gallery", $event))->with("success_message", "event gallery has been deleted successfully.");
    }

    public function removeSponsor(Request $request)
    {
        $event = Event::findOrfail($request->event_id);
        $sponsor = EventSponsor::findOrfail($request->sponsor_id);

        $event->sponsors()->detach($sponsor->id);

        return redirect(route("events.edit", $event))->with("success_message", "event sponsors has been stored successfully.");
    }

    public function addSponsor(Request $request)
    {
        $event = Event::findOrfail($request->event_id);
        $sponsor = EventSponsor::findOrfail($request->event_sponsor_id);

        $event->sponsors()->syncWithoutDetaching($sponsor->id);
        
        return redirect(route("events.edit", $event))->with("success_message", "event sponsors has been stored successfully.");
    }

    public function removeOrganizer(Request $request)
    {
        $event = Event::findOrfail($request->event_id);
        $organizer = EventOrganizer::findOrfail($request->organizer_id);

        $event->organizers()->detach($organizer->id);

        return redirect(route("events.edit", $event))->with("success_message", "event sponsors has been stored successfully.");
    }

    public function addOrganizer(Request $request)
    {
        // dd($request->all());
        $event = Event::findOrfail($request->event_id);
        $organizer = EventOrganizer::findOrfail($request->event_organizer_id);

        $event->organizers()->syncWithoutDetaching($organizer->id);
        
        return redirect(route("events.edit", $event))->with("success_message", "event sponsors has been stored successfully.");
    }
}
