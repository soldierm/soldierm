<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestAfterMiddleware implements Middleware
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
        $response = $next($request);
        echo '我是后置请求中间件';

        return $response;
    }
}