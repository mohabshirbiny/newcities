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
                ->addColumn("actions", function($record) {
                    $edit_link = route("tenders.edit", $record->id);
                    $delete_link = route("tenders.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions'])->make(true);
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
        $categories = TenderCategory::get();
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
        

        $this->validate($request, [
            "city_id" => "required|string",
            "title.ar" => "required|string",
            "title.en" => "required|string",
            "cover" => "required",
            "logo" => "required",
            "body.ar" => "required",
            "body.en" => "required",
            "brief.ar" => "required",
            "brief.en" => "required",
            "contact_details" => "required",
            "social_links" => "required",
        ]);
dd($request->all());
        $requestData = $request->except(['image' , 'cover']);
        
        // send files to rename and upload
        $logo = $this->uploadFile($request->logo , 'City','logo','image','tender_files');
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
        //
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
        //
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
