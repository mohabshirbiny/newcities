<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\ArticleCategory;
use App\City;
use App\Compound;
use App\Http\Controllers\Controller;
use App\Traits\UploadFiles;
use App\Vendor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    use UploadFiles ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.articles.index");
    }

    public function grid()
    {
        $query = Article::query();
        return DataTables::of($query)
            ->addColumn("gallery", function ($record) {
                $link = route("articles.gallery", $record->id);
                return "<a href='$link'>Gellery</a>";
            })
            ->addColumn("actions", function($record) {
                $edit_link = route("articles.edit", $record->id);
                $delete_link = route("articles.destroy", $record->id);
                $actions = "
                    <a href='$edit_link' class='badge bg-warning'>Edit</a>
                    <a href='$delete_link' class='badge bg-danger'>Delete</a>
                ";
                return $actions;
            })
        ->rawColumns(['actions','gallery'])->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ArticleCategory::get();
        $vendors = Vendor::get();
        $compounds = Compound::get();
        $cities = City::get();
        return view("admin.articles.create", compact("categories",'vendors','compounds','cities'));
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
            "article_category_id" => "required",
            "city_id" => "required",
            "vendor_id" => "required",
            "compound_id" => "required",
            "title_en" => "required",
            "title_ar" => "required",
            "image" => "required",
            "brief_en" => "required",
            "brief_ar" => "required",
            "body_en" => "required",
            "body_ar" => "required",
        ]);

        Article::create([
            "city_id" => $request->city_id,
            "article_category_id" => $request->article_category_id,
            "compound_id" => $request->compound_id,
            "vendor_id" => $request->vendor_id,
            "title_ar" => $request->title_ar,
            "title_en" => $request->title_en,
            "image" => $request->title_ar,
            "brief_en" => $request->brief_en,
            "brief_ar" => $request->brief_ar,
            "body_en" => $request->body_en,
            "body_ar" => $request->body_ar,
        ]);

        return redirect(route("articles.index"))->with("success_message", "Article has been stored successfully.");
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
        $article = Article::find($id);
        return view("admin.articles.edit", compact("article"));
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
        $this->validate($request, [
            "article_category_id" => "required",
            "title_en" => "required",
            "title_ar" => "required",
            "image" => "required",
            "brief_en" => "required",
            "brief_ar" => "required",
            "body_en" => "required",
            "body_ar" => "required",
        ]);

        $article = Article::find($id);

        $article->update([
            "article_category_id" => $request->article_category_id,
            "title_ar" => $request->title_ar,
            "title_en" => $request->title_en,
            "image" => $request->title_ar,
            "brief_en" => $request->brief_en,
            "brief_ar" => $request->brief_ar,
            "body_en" => $request->body_en,
            "body_ar" => $request->body_ar,
        ]);

        return redirect(route("articles.index"))->with("success_message", "Article has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();

        return redirect(route("articles.index"))->with("success_message", "Article has been deleted successfully.");
    }

    public function gallery($article_id)
    {
        $article = Article::findOrfail($article_id);
        $gallery = $article->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
        }
        
        return view("admin.articles.gallery.index", compact("article_id", "gallery_decoded"));
    }

    public function createGallery($article_id)
    {
        return view("admin.articles.gallery.create", compact("article_id"));
    }

    public function storeGallery(Request $request, $article_id)
    {
        $article = Article::findOrfail($article_id);

        if (in_array($request->file_type, ['image', 'video'])) {
            $uploaded_gallery = $this->uploadFile($request->gallery, 'Article', 'gallery', $request->file_type, 'article_files');
        } else {
            $uploaded_gallery = $request->gallery;
        }

        $gallery = $article->gallery;
        $gallery_decoded = [];
        if ($gallery) {
            $gallery_decoded = json_decode($gallery, true);
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        } else {
            $gallery_decoded[$request->file_type][] = $uploaded_gallery;
        }

        $article->update([
            "gallery" => json_encode($gallery_decoded),
        ]);

        return redirect(route("articles.gallery", $article))->with("success_message", "article gallery has been stored successfully.");
    }

    public function deleteGallery($article_id, $file_name)
    {
        $article = Article::findOrfail($article_id);

        $gallery = $article->gallery;
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
            $article->update([
                "gallery" => json_encode($new_gallery),
            ]);

            return redirect(route("articles.gallery", $article))->with("success_message", "article gallery has been deleted successfully.");
        }
        return redirect(route("articles.gallery", $article))->with("success_message", "article gallery has been deleted successfully.");
    }
}
