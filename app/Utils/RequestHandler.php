<?php

namespace App\Utils;

use App\Models\Request;
use Illuminate\Support\Facades\Request as HttpRequest;

class RequestHandler
{

    public static function saveRequest($url, $body, $code, $response, $error = false)
    {
        $re = Request::create([
            'user_id' => HttpRequest::user()->id,
            'url' => $url,
            'body' => (is_array($body) ? json_encode($body) : $body),
            'code' => $code,
            'response' => (is_array($response) ? json_encode($response) : $response),
            'ip' => HttpRequest::ip(),
            'erorr' => $error,
        ]);
        $re->save();
        return $re;
    }
}
