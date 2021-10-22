<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Services\AuthService;
use Illuminate\Http\Request;

/**
 * 测试授权控制器
 */
class AuthController extends Controller
{
    /**
     * @throws ApiException
     */
    public function authorizing(Request $request)
    {
        $success = 0;
        $data = [];
        if ($code = $request->get('code')) {
            $service = new AuthService();
            $service->token = 'e6l8vHh8nG6L-DmAjINWuR5CIGApqMsQD5u1qQjMwzyB1d-clSNsgkMoxHXceLJ_fPVWk9b4-G4uaGe_7rsSQ_Lus25Kj2jGfqRBk4JINVFkKcyNQPWkPKXXZYua0HZA9YmyaDPYA1QxAVnyNnGKAHKn3xv0iWjzjCWZ6vuvl7buayq5xFBT1pfG8WQppY07EjucqCtIirPGBNF02ap8sg';
            $data = $service->user($code);
            var_dump($data);
        }
        return view('authorizing', ['success' => $success, 'data' => $data]);
    }
}
