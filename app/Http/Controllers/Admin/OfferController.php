<?php

namespace App\Http\Controllers\Admin;

use App\Offer;
use App\Http\Controllers\Controller;
use App\OfferCategory;
use App\Traits\UploadFiles;
use App\Vendor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
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
            
            $query = Offer::query();                                        
            
            return DataTables::of($query)
                ->addColumn("gallery", function ($record) {
                    $link = route("offers.gallery", $record->id);
                    return "<a href='$link'>Gellery</a>";
                })
                ->addColumn("actions", function($record) {
                    $edit_link = route("offers.edit", $record->id);
                    $delete_link = route("offers.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions','gallery'])->make(true);
        } else {
            return view("admin.offers.index");
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $OfferCategories = OfferCategory::query()->select(['id','name'])->get();
        $vendors = Vendor::all();                                        
        return view("admin.offers.create",compact('OfferCategories','vendors'));
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
            "offer_category_id" => "required|integer",
            "vendor_id" => "required|integer",
            "title.ar" => "required",
            "title.en" => "required",
            "image" => "required|file",
            "price_before" => "required",
            "price_after" => "required",
            "discount_percentage" => "required",
            "description.ar" => "required",
            "description.en" => "required",
            "expiration_date" => "required|date",
            "url" => "required|url",
            "order_tel_number" => "required",
        ]);

        $requestData = $request->except(['image' ]);
        
        // send files to rename and upload
        $image = $this->uploadFile($request->image , 'Offer','image','image','offer_files');

        $offerData = [

            'image'  => $image,
            'title'  => serialize($request->title ),
            'description'     => serialize($request->description ),
            'product_id'     => '0',
        ];
        
        $offerData = array_merge($requestData , $offerData);
            //  dd($offerData);
        $offer = Offer::create($offerData);

        return redirect()->route('offers.index')->withSuccess( 'offer created !');
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
        $OfferCategories = OfferCategory::query()->select(['id','name'])->get();                                        
        $vendors = Vendor::all();                                        
        $offer = Offer::findorfail($id);
        return view("admin.offers.edit", compact("OfferCategories",'offer','vendors'));
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
        $offer = Offer::findorfail($id);

        $this->validate($request, [
            "offer_category_id" => "required|integer",
            "vendor_id" => "required|integer",
            "title.ar" => "required",
            "title.en" => "required",
            "image" => "file",
            "price_before" => "required",
            "price_after" => "required",
            "discount_percentage" => "required",
            "description.ar" => "required",
            "description.en" => "required",
            "expiration_date" => "required|date",
            "url" => "required|url",
            "order_tel_number" => "required",
        ]);

        $requestData = $request->except(['image']);
        $offerData= [];

        if ($request->image) { 
            // send files to rename and upload
            $newImage = $this->uploadFile($request->image , 'Offer','image','image','offer_files');
            $offerData['image'] = $newImage;
        }else{
            $offerData['image'] = $offer->image;
        }

        $offerData = array_merge($offerData,[
            'title'  => serialize($request->title ),
            'description'     => serialize($request->description ),
            'product_id'     => '0',
        ]);
        
        $offerData = array_merge($requestData , $offerData);
            //  dd($offerData);
        $offer->update($offerData);

        return redirect()->route('offers.index')->withSuccess( 'offer updated !');
    
    
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

    public function gallery($offer_id)
    {
        $offer = Offer::findOrfail($offer_id);
        $gallery = $offer->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }
        
        return view("admin.offers.gallery.index", compact("offer_id", "gallery_decoded"));
    }

    public function createGallery($offer_id)
    {
        return view("admin.offers.gallery.create", compact("offer_id"));
    }

    public function storeGallery(Request $request, $offer_id)
    {
        $offer = Offer::findOrfail($offer_id);

        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'Offer', 'gallery', $request->file_type, 'offer_files');
        } else {
            $uploaded_gallery = $request->gallery;
        }

        $gallery = $offer->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        } else {
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $offer->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("offers.gallery", $offer))->with("success_message", "offer gallery has been stored successfully.");
    }

    public function deleteGallery($offer_id, $file_name)
    {
        $offer = Offer::findOrfail($offer_id);

        $gallery = $offer->gallery;
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
            $offer->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("offers.gallery", $offer))->with("success_message", "offer gallery has been deleted successfully.");
        }
        return redirect(route("offers.gallery", $offer))->with("success_message", "offer gallery has been deleted successfully.");
    }
}
