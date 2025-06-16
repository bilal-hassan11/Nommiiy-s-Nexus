<?php

/**
 * Write code on Method
 *
 * @return response()
 */

use App\Models\User;


if (!function_exists('changeDateFormatToUS')) {
    function changeDateFormatToUS($date)
    {
        return date("m-d-Y", strtotime($date));
    }
}


if (!function_exists('get_system_user_id')) {
    function get_system_user_id()
    {
        $user_id = auth()->user()->id;
        $systemUser = User::where('id', $user_id)->first();

        if ($systemUser->type == 'user') {
            return $systemUser->system_user_id;
        } else {
            return $systemUser->id;
        }
    }
}


if (!function_exists('get_login_user_id')) {
    function get_login_user_id()
    {
        $user_id = auth()->user()->id;
        if ($user_id) {
            return $user_id;
        } else {
            return false;
        }
    }
}

if (!function_exists('sendResponse')) {

    function sendResponse($error, $code, $data, $message)
    {
        $response = [
            'errors' => $error,
            'code' => $code,
            'data'    => $data,
            'message' => $message,
        ];


        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }
}
