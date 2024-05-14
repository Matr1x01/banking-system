<?php
namespace App\Helper;

use Symfony\Component\HttpFoundation\Response;

class JsonResponder
{
    public static function respond($message = 'success', $code = Response::HTTP_OK, $data = [])
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}