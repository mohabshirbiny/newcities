<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TenderCategory;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TenderCategoryController extends Controller
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
            
            $query = TenderCategory::query();                                        
            
            return DataTables::of($query)
                ->addColumn("actions", function($record) {
                    $edit_link = route("tenders-categories.edit", $record->id);
                    $delete_link = route("tenders-categories.destroy", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                        <a href='$delete_link' class='badge bg-danger'>Delete</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions'])->make(true);
        } else {
            return view("admin.tenders_categories.index");
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.tenders_categories.create");
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
        $icon = $this->uploadFile($request->icon , 'TenderCategory','icon','image','tenders_categories_files');

        $cityData = [

            'icon'  => $icon,
            'name'  => serialize($request->name ),
        ];
        
        $TenderCategoryData = array_merge($requestData , $cityData);
             //dd($TenderCategoryData);
        $tenderCategory = TenderCategory::create($TenderCategoryData);

        return redirect()->route('tenders-categories.index')->withSuccess( 'Tender category created !');
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
        $tenderCategory = TenderCategory::findorfail($id);
        return view("admin.tenders_categories.edit", compact("tenderCategory"));
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
        $tenderCategory = TenderCategory::findorfail($id);

        $this->validate($request, [
            "name.ar" => "required|string",
            "name.en" => "required|string",
            "icon" => "file",
        ]);

        $requestData = $request->except(['icon']);
        
        if ($request->icon) { 
            // send files to rename and upload
            $newIcon = $this->uploadFile($request->icon , 'TenderCategory','icon','image','tenders_categories_files');
            $cityData['icon'] = $newIcon;
        }else{
            $cityData['icon'] = $tenderCategory->icon;
        }

        $cityData['name']  = serialize($request->name);
        
        $TenderCategoryData = array_merge($requestData , $cityData);
             //dd($TenderCategoryData);
        $tenderCategory->update($TenderCategoryData);

        return redirect()->route('tenders-categories.index')->withSuccess( 'Tender category created !');
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
