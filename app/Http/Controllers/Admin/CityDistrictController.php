<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\City;
use App\CityDistrict;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use Yajra\DataTables\Facades\DataTables;

class CityDistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            
            $query = CityDistrict::query();                                        
            
            return DataTables::of($query)
                ->addColumn("actions", function($record) {
                    $edit_link = route("city-districts.edit", $record->id);
                    $delete_link = route("city-districts.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions'])->make(true);
        } else {
            return view("admin.cities_districts.index");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::query()->select('id','name_en','name_ar')->get();
        return view("admin.cities_districts.create",compact('cities'));
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
            "name_ar" => "required|string",
            "name_en" => "required|string",
            "location_url" => "required",
            "city_id" => "required",
        ]);

        $cityDistrict = CityDistrict::create($request->all());

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
        $cityDistrict = CityDistrict::findorfail($id); 
        
        $cities = City::query()->select('id','name_en','name_ar')->get();
        
        return view("admin.cities_districts.edit",compact('cities','cityDistrict'));        
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
        $cityDistrict = CityDistrict::findorfail($id); 

        $this->validate($request, [
            "name_ar" => "required|string",
            "name_en" => "required|string",
            "location_url" => "required",
            "city_id" => "required",
        ]);

        $cityDistrict->update($request->all());

        return redirect()->route('city-districts.index')->withSuccess( 'district updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id);
        $article_category = CityDistrict::findorfail($id);
        $article_category->delete();

        return redirect(route("city-districts.index"))->with("success_message", "Article category has been deleted successfully.");
    }
}
