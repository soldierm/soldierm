<?php

namespace App\Http\Middleware;

use App\Base\Middleware;
use Closure;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HtmlEchoMiddleware implements Middleware
{
    /**
     * 相应Json化
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('Content-type', 'text/html');
        $response->setContent(app()->getContainer()->originContent);

        return $response;
    }
}
