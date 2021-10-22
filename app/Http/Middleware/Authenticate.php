<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     * @throws ApiException
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            throw new ApiException('请先登录');
        }
    }
}
