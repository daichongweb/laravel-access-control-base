<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Exceptions\LoginException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return void
     * @throws LoginException
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            throw new LoginException('请先登录');
        }
    }
}
