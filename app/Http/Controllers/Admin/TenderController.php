<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Tender;
use App\Http\Controllers\Controller;
use App\TenderCategory;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TenderController extends Controller
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
            
            $query = Tender::query();                                        
            
            return DataTables::of($query)
                ->addColumn("gallery", function ($record) {
                    $link = route("tenders.gallery", $record->id);
                    return "<a href='$link'>Gellery</a>";
                })
                ->addColumn("actions", function($record) {
                    $edit_link = route("tenders.edit", $record->id);
                    $delete_link = route("tenders.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions','gallery'])->make(true);
        } else {
            return view("admin.tenders.index");
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = TenderCategory::query()->select(['id','name'])->get();                                        
        $cities = City::get();
        return view("admin.tenders.create",compact('categories','cities'));

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
            "city_id" => "required|string",
            "tender_category_id" => "required|string",
            "title.ar" => "required|string",
            "title.en" => "required|string",
            "attachment" => "required",
            "image" => "required",
            "body.ar" => "required",
            "body.en" => "required",
            "brief.ar" => "required",
            "brief.en" => "required",
            "date_from" => "required|date",
            "date_to" => "required|date",
            "book_value" => "required",
            "insurance_value" => "required",
        ]);
    // dd($request->all());
        $requestData = $request->except(['image' , 'attachment']);
        
        // send files to rename and upload
        $image = $this->uploadFile($request->image , 'Tender','logo','image','tender_files');

        $tenderDate = [

            'image'  => $image,
            'attachment'  => '0',
            'title'  => serialize($request->title ),
            'body'     => serialize($request->body ),
            'brief'     => serialize($request->brief ),
        ];
        
        $tenderDate = array_merge($requestData , $tenderDate);
            // dd($tenderDate);
        $tender = Tender::create($tenderDate);

        return redirect()->route('tenders.index')->withSuccess( 'tender created !');
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
        $TenderCategories = TenderCategory::query()->select(['id','name'])->get();                                        
        $cities = City::query()->select(['id','name_en','name_ar'])->get();                                        

        $tender = Tender::findorfail($id);
        return view("admin.tenders.edit", compact("TenderCategories",'tender','cities'));
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
        // dd($request->all());
        $tender = Tender::findorfail($id);

        $this->validate($request, [
            "city_id" => "required|string",
            "tender_category_id" => "required|string",
            "title.ar" => "required|string",
            "title.en" => "required|string",
            "attachment" => "file",
            "image" => "file",
            "body.ar" => "required",
            "body.en" => "required",
            "brief.ar" => "required",
            "brief.en" => "required",
            "date_from" => "required|date",
            "date_to" => "required|date",
            "book_value" => "required",
            "insurance_value" => "required",
        ]);
    // dd($request->all());
        $requestData = $request->except(['image' , 'attachment']);
        
        if ($request->image) { 
            // send files to rename and upload
            $newImage = $this->uploadFile($request->image , 'Tender','logo','image','tender_files');
            $tenderData['image'] = $newImage;
        }else{
            $tenderData['image'] = $tender->image;
        }

        if ($request->image) { 
            // send files to rename and upload
            // $newImage = $this->uploadFile($request->attachment , 'Tender','logo','image','tender_files');
            // $tenderData['attachment'] = $newImage;
        }else{
            $tenderData['attachment'] = $tender->attachment;
        }

        $tenderDate = array_merge($tenderData ,[
            'title'  => serialize($request->title ),
            'body'     => serialize($request->body ),
            'brief'     => serialize($request->brief ),
        ]);
        
        $tenderDate = array_merge($requestData , $tenderDate);
            // dd($tenderDate);
        $tender->update($tenderDate);

        return redirect()->route('tenders.index')->withSuccess( 'tender created !');
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

    public function gallery($tender_id)
    {
        $tender = Tender::findOrfail($tender_id);
        $gallery = $tender->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }
        
        return view("admin.tenders.gallery.index", compact("tender_id", "gallery_decoded"));
    }

    public function createGallery($tender_id)
    {
        return view("admin.tenders.gallery.create", compact("tender_id"));
    }

    public function storeGallery(Request $request, $tender_id)
    {
        $tender = Tender::findOrfail($tender_id);

        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'Tender', 'gallery', $request->file_type, 'tender_files');
        } else {
            $uploaded_gallery = $request->gallery;
        }

        $gallery = $tender->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        } else {
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $tender->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("tenders.gallery", $tender))->with("success_message", "tender gallery has been stored successfully.");
    }

    public function deleteGallery($tender_id, $file_name)
    {
        $tender = Tender::findOrfail($tender_id);

        $gallery = $tender->gallery;
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
            $tender->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("tenders.gallery", $tender))->with("success_message", "tender gallery has been deleted successfully.");
        }
        return redirect(route("tenders.gallery", $tender))->with("success_message", "tender gallery has been deleted successfully.");
    }
}
