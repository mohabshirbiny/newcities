<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\CityDistrict;
use App\Compound;
use App\Contractor;
use App\Developer;
use App\Http\Controllers\Controller;
use App\SectionData;
use Illuminate\Support\Facades\DB;

class CompoundController extends Controller
{
    public function getAll()
    {
        $query = Compound::query();

        if (request()->city_id && request()->city_id != "") {
            $query->where("city_id", request()->city_id);
        }

        if (request()->district_id && request()->district_id != "") {
            $query->where("district_id", request()->district_id);
        }

        $records = $query->get();

        $districts = CityDistrict::where("city_id", request()->city_id)->get();

        $section = SectionData::where('model', 'Compound')->first();

        $data = [
            "locations" => $districts,
            "compounds" => $records,
            "gallery" => ($section) ? $section->section_gallery : (object) [],
        ];

        return APIResponseController::respond(1, "Compounds", $data, 200);
    }

    public function getOne($id)
    {
        $data['details'] = Compound::find($id);

        $developers_ids = DB::table('compound_developer')->where("compound_id", $id)->pluck("developer_id")->toArray();
        $data['developers'] = Developer::whereIn("id", $developers_ids)->get();

        $contractors_ids = DB::table('compound_contractor')->where("contractor_id", $id)->pluck("contractor_id")->toArray();
        $data['contractors'] = Contractor::whereIn("id", $contractors_ids)->get();

        $data['news'] = Article::where("compound_id", $id)->get();

        return APIResponseController::respond(1, "Compound details", $data, 200);
    }
}
