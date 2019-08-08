<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestBeforeMiddleware implements Middleware
{
    /**
     * 验证中间件
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        echo '我是前置请求中间件';

        return $next($request);
    }
}