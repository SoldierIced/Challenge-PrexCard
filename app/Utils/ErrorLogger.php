<?php

namespace App\Utils;

use App\Models\ErrorLog;
use Illuminate\Support\Facades\Request;
use Throwable;
use GuzzleHttp\Exception\RequestException;

class ErrorLogger
{
    public static function logError(Throwable $exception)
    {
        $errorType = $exception instanceof RequestException ? 'RequestException' : 'Throwable';

        ErrorLog::create([
            'error_type' => $errorType,
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'code' => $exception->getCode(),
            'url' => Request::url(),
            'trace' => json_encode($exception->getTrace(), JSON_PRETTY_PRINT),
            'created_at' => now(),
        ]);
    }
}
