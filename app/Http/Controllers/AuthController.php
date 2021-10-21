<?php

namespace App\Http\Controllers;

use App\Data\EnterpriseRedis;
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
            $service->token = 'DUKxpdTlyma_7E97_sJdIuz6vbu074ULsZLjvej14id6AqJ3oUVx8dMt8Ez_zZ4ZQTV0NlU4Po-8-fixCnOpLPmeQ94T0wjQ2ExMPwXw7aB10Ba05p8EccbrAkbpC_EprfC_nSVcJifpdi99rDTi4rg-l_nrJ_At_fq9atx9gXEFRW_DdzcOgbeL1KX-9nryhhFW_zPSYXFU7BUk28ZY1g';
            $data = $service->user($code);
            var_dump($data);
        }
        return view('authorizing', ['success' => $success, 'data' => $data]);
    }
}
