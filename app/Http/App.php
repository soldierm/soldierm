<?php

namespace App\Http;

use App\Base\App as BaseApp;
use App\Http\Exception\MethodNotAllowedException;
use App\Http\Exception\NofFoundException;
use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use function FastRoute\simpleDispatcher;

class App extends BaseApp
{
    /**
     * 请求
     *
     * @var Request
     */
    protected $request;

    /**
     * 响应
     *
     * @var Response
     */
    protected $response;

    /**
     * 路由
     *
     * @var Dispatcher
     */
    protected $routeDispatcher;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        $this->registerErrorHandler();

        $this->container['routeDispatcher'] = $this->routeDispatcher = simpleDispatcher($this->getConfig()->get('route'));
        $this->container['request'] = $this->request = Request::createFromGlobals();
        $this->container['response'] = $this->response = new Response();
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        $parsedUri = $this->parseUri();
        $content = http_format(Response::HTTP_OK, 'success', call_user_func_array($parsedUri[0], $parsedUri[1]));
        $this->sendResponse($content);
    }

    /**
     * 美化报错页面
     *
     * @return void
     */
    protected function registerErrorHandler()
    {
        if ($this->container['debug']) {
            $whoops = new Run();
            $whoops->prependHandler(new PrettyPageHandler());
            $whoops->register();
        }
    }

    /**
     * 解析路由
     *
     * @return array
     * @throws MethodNotAllowedException
     * @throws NofFoundException
     */
    protected function parseUri()
    {
        $routeInfo = $this->routeDispatcher->dispatch($this->request->getMethod(), $this->request->getRequestUri());
        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedException($this->request->getMethod());
                break;
            case Dispatcher::NOT_FOUND:
            default:
                throw new NofFoundException();
                break;
        }
        return [$handler, $vars];
    }

    /**
     * 发送请求
     *
     * @param array $content
     */
    protected function sendResponse(array $content)
    {
        /* 暂时只提供json接口 */
        $this->response->headers->set('Content-type', 'application/json;charset=UTF-8');
        $this->response->setContent(json_encode($content))
            ->setStatusCode(Response::HTTP_OK)
            ->send();
        exit;
    }
}