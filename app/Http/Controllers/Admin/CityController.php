<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
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
                ->addColumn("actions", function($record) {
                    $edit_link = route("cities.edit", $record->id);
                    $delete_link = route("cities.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions'])->make(true);
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
        return view("admin.cities.create");
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

            'cover'  => 'tst',
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
        return redirect()->route('cities.index')->withSuccess( 'تم انشاء المدينة بنجاح !');
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
