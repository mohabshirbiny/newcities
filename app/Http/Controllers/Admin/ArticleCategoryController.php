<?php

namespace App\Http\Controllers\Admin;

use App\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.article_categories.index");
    }

    public function grid()
    {
        $query = ArticleCategory::query();
        return DataTables::of($query)
            ->addColumn("actions", function($record) {
                $edit_link = route("article-categories.edit", $record->id);
                $delete_link = route("article-categories.destroy", $record->id);
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
        return view("admin.article_categories.create");
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
            "title_en" => "required",
            "title_ar" => "required",
            "icon" => "required"
        ]);

        ArticleCategory::create([
            "title_en" => $request->title_en,
            "title_ar" => $request->title_ar,
            "icon" => $request->icon,
        ]);

        return redirect(route("article-categories.index"))->with("success_message", "Article category has been stored successfully.");
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
        $article_category = ArticleCategory::find($id);
        return view("admin.article_categories.edit", compact("article_category"));
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
            "title_en" => "required",
            "title_ar" => "required",
            "icon" => "required"
        ]);

        $article_category = ArticleCategory::find($id);

        $article_category->update([
            "title_en" => $request->title_en,
            "title_ar" => $request->title_ar,
            "icon" => $request->icon,
        ]);

        return redirect(route("article-categories.index"))->with("success_message", "Article category has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article_category = ArticleCategory::find($id);
        $article_category->delete();

        return redirect(route("article-categories.index"))->with("success_message", "Article category has been deleted successfully.");
    }
}
