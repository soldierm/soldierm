<?php

namespace App\Http\Middleware;

use App\Base\Middleware;
use App\Http\Exception\AuthException;
use Closure;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware implements Middleware
{
    /**
     * 需要登录的路由
     *
     * @var array
     */
    private static $login = [
        '/logout'
    ];

    /**
     * 绝对不需要登录的路由
     *
     * @var array
     */
    private static $guest = [
        '/login'
    ];

    /**
     * 登录中间件
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $pathInfo = $request->getPathInfo();
        $isLogin = container()->user->isLogin();
        if (in_array($pathInfo, self::$login) && !$isLogin) {
            throw new AuthException('Please login first.');
        } elseif (in_array($pathInfo, self::$guest) && $isLogin) {
            throw new AuthException('Please logout first.');
        }
        return $next($request);
    }
}
