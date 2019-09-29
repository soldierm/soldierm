<?php

namespace App\Api\Middleware;

use App\Base\Middleware;
use Closure;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonEchoMiddleware implements Middleware
{
    /**
     * 相应Json化
     *
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var JsonResponse $response */
        $response = $next($request);

        $response->setData(http_format($response->getStatusCode(), 'ok', app()->getContainer()->originContent));

        return $response;
    }
}
