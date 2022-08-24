<?php
namespace App\Helpers;

class JsonFormatter{
    protected static $response = [
        'code' => null,
        'message' => null,
        'length' => null,
        'data' => null
    ];

    public static function JsonFormat($code = null, $message = null, $length = null, $data = null){
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['length'] = $length;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['code']);
    }
}

?>
