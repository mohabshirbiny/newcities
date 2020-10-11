<?php

namespace App\Http\Controllers\Admin;

use App\SectionData;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SectionDataController extends Controller
{
    use UploadFiles;

    public function getAll(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            
            $query = SectionData::query();                                        
            
            return DataTables::of($query)
                ->addColumn("gallery", function ($record) {
                    $link = route("sections.gallery", $record->id);
                    return "<a href='$link'>Gellery</a>";
                })
                ->addColumn("actions", function($record) {
                    $edit_link = route("sections.edit", $record->id);
                    $actions = "
                        <a href='$edit_link' class='badge bg-warning'>Edit</a>
                    ";
                    return $actions;
                })
            ->rawColumns(['actions','gallery'])->make(true);
        } else {
            return view("admin.sections_data.index");
        } 
        
    }


    public function edit( $id)
    {
        $section = SectionData::findorfail($id);  
        return view("admin.sections_data.edit",compact('section'));
    }

    public function update (Request $request,$id)
    {
        $section = SectionData::findorfail($id);
        
        $this->validate($request, [
            "title.en" => "required",
            "title.ar" => "required",
            "icon" => "file",
        ]);
            // dd($request->all());
        $requestData = $request->except(['icon','_method','_token']);

        if ($request->icon) { 
            // send files to rename and upload
            $newImage = $this->uploadFile($request->icon , 'SectionData','icon','image','section_files');
            $sectionData['icon'] = $newImage;
        }else{
            $sectionData['icon'] = $section->icon;
        }

        $sectionData = array_merge($sectionData,[
            'title'  => serialize($request->title ),
        ]);
        
        $sectionData = array_merge($requestData , $sectionData);
            //  dd($sectionData);
        $section->update($sectionData);

        return redirect(route("sections.index"))->with("success_message", "section has been updated successfully.");
    }


    public function gallery($section_id)
    {
        $section = SectionData::findOrfail($section_id);
        $gallery = $section->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }
        
        return view("admin.sections_data.gallery.index", compact("section_id", "gallery_decoded"));
    }

    public function createGallery($section_id)
    {
        return view("admin.sections_data.gallery.create", compact("section_id"));
    }

    public function storeGallery(Request $request, $section_id)
    {
        $section = SectionData::findOrfail($section_id);

        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'SectionData', 'gallery', $request->file_type, 'section_files');
        } else {
            $uploaded_gallery = $request->gallery;
        }

        $gallery = $section->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        } else {
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $section->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("sections.gallery", $section))->with("success_message", "section gallery has been stored successfully.");
    }

    public function deleteGallery($section_id, $file_name)
    {
        $section = SectionData::findOrfail($section_id);

        $gallery = $section->gallery;
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
            $section->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("sections.gallery", $section))->with("success_message", "section gallery has been deleted successfully.");
        }
        return redirect(route("sections.gallery", $section))->with("success_message", "section gallery has been deleted successfully.");
    }

    
}
