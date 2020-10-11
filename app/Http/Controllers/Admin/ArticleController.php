<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\ArticleCategory;
use App\Compound;
use App\Http\Controllers\Controller;
use App\Vendor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
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
            ->addColumn("actions", function($record) {
                $edit_link = route("articles.edit", $record->id);
                $delete_link = route("articles.destroy", $record->id);
                $actions = "
                    <a href='$edit_link' class='badge bg-warning'>Edit</a>
                    <a href='$delete_link' class='badge bg-danger'>Delete</a>
                ";
                return $actions;
            })
        ->rawColumns(['actions'])->make(true);
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
        return view("admin.articles.create", compact("categories",'vendors','compounds'));
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
}
