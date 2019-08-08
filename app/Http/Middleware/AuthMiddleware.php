<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware implements Middleware
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
        if (app()->getContainer()->author !== 'zhouyang') {
            throw new Exception("你是谁啊？");
        }

        return $next($request);
    }
}