<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class LoginException extends \Exception
{
    public function __construct($message, $code = 401)
    {
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        $content = [
            'message' => $this->message,
            'code' => 401,
            'status' => 'error',
            'timestamp' => date('Y-m-d H:i:s')
        ];

        return response()->json($content, 401);
    }
}
