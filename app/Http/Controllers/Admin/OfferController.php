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
                ->addColumn("actions", function($record) {
                    $edit_link = route("offers.edit", $record->id);
                    $delete_link = route("offers.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions'])->make(true);
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
        $vendors = Vendor::query()->select(['id','title_en','title_ar'])->get();                                        
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
        $vendors = Vendor::query()->select(['id','title_en','title_ar'])->get();                                        
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
}
