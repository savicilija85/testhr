<?php
/**
 * Created by PhpStorm.
 * User: webup07
 * Date: 18.1.18.
 * Time: 14.39
 */

namespace App\Classes;


class JsonResponse
{
    public static function response($status, $data = [], $message){
        $customData = [
            'status' => $status,
            'data' => $data,
            'message' => $message

        ];
        return $customData;
    }
}