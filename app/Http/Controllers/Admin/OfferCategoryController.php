<?php

namespace App\Http\Controllers\Admin;

use App\Offer;
use App\OfferCategory;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OfferCategoryController extends Controller
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
            
            $query = OfferCategory::query();                                        
            
            return DataTables::of($query)
                ->addColumn("actions", function($record) {
                    $edit_link = route("offers-categories.edit", $record->id);
                    $delete_link = route("offers-categories.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions'])->make(true);
        } else {
            return view("admin.offers_categories.index");
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.offers_categories.create");
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
            "name.ar" => "required|string",
            "name.en" => "required|string",
            "icon" => "required|file",
        ]);

        $requestData = $request->except(['icon']);
        
        // send files to rename and upload
        $icon = $this->uploadFile($request->icon , 'OfferCategory','icon','image','offers_categories_files');

        $cityData = [

            'icon'  => $icon,
            'name'  => serialize($request->name ),
        ];
        
        $OfferCategoryData = array_merge($requestData , $cityData);
             //dd($OfferCategoryData);
        $offerCategory = OfferCategory::create($OfferCategoryData);

        return redirect()->route('offers.categories.index')->withSuccess( 'Offer category created !');
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
        $offerCategory = OfferCategory::findorfail($id);
        return view("admin.offers_categories.edit", compact("offerCategory"));
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
        $offerCategory = OfferCategory::findorfail($id);

        $this->validate($request, [
            "name.ar" => "required|string",
            "name.en" => "required|string",
            "icon" => "file",
        ]);

        $requestData = $request->except(['icon']);
        
        if ($request->icon) { 
            // send files to rename and upload
            $newIcon = $this->uploadFile($request->icon , 'OfferCategory','icon','image','offers_categories_files');
            $cityData['icon'] = $newIcon;
        }else{
            $cityData['icon'] = $offerCategory->icon;
        }

        $cityData['name']  = serialize($request->name);
        
        $OfferCategoryData = array_merge($requestData , $cityData);
             //dd($OfferCategoryData);
        $offerCategory->update($OfferCategoryData);

        return redirect()->route('offers-categories.index')->withSuccess( 'Offer category created !');
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
