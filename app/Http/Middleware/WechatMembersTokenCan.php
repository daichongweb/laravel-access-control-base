<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;
use Illuminate\Http\Request;

class WechatMembersTokenCan
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
        if ($request->user()->getTable() !== 'wechat-members') {
            throw new ApiException('无权限操作！');
        }
        return $next($request);
    }
}
