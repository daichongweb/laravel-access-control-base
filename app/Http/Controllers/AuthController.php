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
            $service->token = 'Zaw9OS56OMIoK3MFrbD4_i6UPlbIAP1e8VTpt9hRV4T_5tsqBCj4HIgFUlAc1WrYQ-3A73sUu_qKCEuCnQsKLf9NFH3oM1-1m8vObEadHd7aT-UQoSbb85Q_XAI96oHkBnSK3db34yBH9NLd-nGgQZ7tij6lcxOVvl_IU4Ju3z_6dVoR9p_n-m4jmy1BZZM37wxnYyeAixHILJDI7yfmDQ';
            $data = $service->user($code);
            var_dump($data);
        }
        return view('authorizing', ['success' => $success, 'data' => $data]);
    }
}
