<?php

namespace App\Http\Controllers;

use App\Utils\ErrorLogger;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected function sendResponse($data, $message = null, $status = "success", $e = null, $code = Response::HTTP_OK): JsonResponse
    {
        if ($e != null) {
            ErrorLogger::logError($e);
        }
        if (env("SHOW_ERR") == true &&  $e != null) {
            $message = $e->getMessage() ?? $message;
        }
        $data['status'] = $status;
        if ($message)
            $data['message'] = $message;
        if (!isset($data["data"]))
            $data["data"] = null;
        return response()->json($data, $code);
    }
}
