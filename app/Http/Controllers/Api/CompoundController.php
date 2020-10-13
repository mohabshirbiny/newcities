<?php

namespace App\Http\Controllers\Api;

use App\Compound;
use App\Contractor;
use App\Developer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CompoundController extends Controller
{
    public function getAll()
    {
        $query = Compound::query();

        if (request()->city_id && request()->city_id != "") {
            $query->where("city_id", request()->city_id);
        }

        $records = $query->get();

        return APIResponseController::respond(1, "Compounds", ["compounds" => $records], 200);
    }

    public function getOne($id)
    {
        $data['details'] = Compound::find($id);

        $developers_ids = DB::table('compound_developer')->where("compound_id", $id)->pluck("developer_id")->toArray();
        $data['developers'] = Developer::whereIn("id", $developers_ids)->get();

        $contractors_ids = DB::table('compound_contractor')->where("contractor_id", $id)->pluck("contractor_id")->toArray();
        $data['contractors'] = Contractor::whereIn("id", $contractors_ids)->get();

        return APIResponseController::respond(1, "Compound details", $data, 200);
    }
}
