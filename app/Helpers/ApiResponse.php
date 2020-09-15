<?php

if (!function_exists("api_response")) {
    function api_response($status, $message, $data)
    {
        if($data) {
            return response()->json(['status' => $status, "message" => $message, "data" => $data]);
        }
        return response()->json(['status' => $status, "message" => $message, "data" => ['data' => []]]);
    }
}
