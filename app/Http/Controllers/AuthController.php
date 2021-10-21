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
            $data = $service->user($code);
            var_dump($data);
        }
        return view('authorizing', ['success' => $success, 'data' => $data]);
    }
}
