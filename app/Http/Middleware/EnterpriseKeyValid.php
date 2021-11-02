<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;
use Illuminate\Http\Request;

/**
 * 验证企业标识
 */
class EnterpriseKeyValid
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     * @throws ApiException
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('key')) {
            throw new ApiException('无权限操作，请先绑定企业');
        }
        return $next($request);
    }
}
