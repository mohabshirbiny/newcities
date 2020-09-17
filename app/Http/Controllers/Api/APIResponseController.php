<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class APIResponseController extends Controller
{
    public static function respond($status,$message=[],$data=[],$httpCode=200){
        
        $return=[];
        
        $return['status']= $status;
        $return['message']= [];
        $return['data']= [];

        foreach ($message as $key => $value) {
            $return['message'][$key]=$value;
        }

        foreach ($data as $key => $value) {
            $return['data'][$key]=$value;
        }

        return Response::json($return, $httpCode, array(), JSON_PRETTY_PRINT);
    }
}
