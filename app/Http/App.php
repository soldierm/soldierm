<?php

namespace App\Http;

use App\Base\App as BaseApp;
use App\Base\Controller;
use App\Base\Exception;
use App\Http\Exception\JsonResponseHandle;
use App\Http\Exception\MethodNotAllowedException;
use App\Http\Exception\NofFoundException;
use App\Http\Exception\UnknownException;
use App\Http\Middleware\Middleware;
use Exception as PHPException;
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
     * 全局请求处理中间件
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * 控制器
     *
     * @var Controller|callable
     */
    protected $controller;

    /**
     * 控制器参数
     *
     * @var array
     */
    protected $controllerArgs;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        $this->registerErrorHandler();

        $this->container['request'] = $this->request = Request::createFromGlobals();
        $this->container['routeDispatcher'] = $this->routeDispatcher = simpleDispatcher($this->getConfig()->get('route'));
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        try {
            $this->parseUri();
            $this->callMiddleware();
        } catch (Exception $exception) {
            $this->response->setContent($exception);
        } catch (PHPException $exception) {
            $this->response->setContent(new UnknownException($exception->getMessage()));
        }
        $this->response->send();
        exit;
    }

    /**
     * 美化报错页面
     *
     * @return void
     */
    protected function registerErrorHandler()
    {
        $whoops = new Run();
        if ($this->container['debug']) {
            $whoops->prependHandler(new PrettyPageHandler());
        } else {
            $whoops->prependHandler(new JsonResponseHandle());
        }
        $whoops->register();
    }

    /**
     * 解析路由
     *
     * @throws MethodNotAllowedException
     * @throws NofFoundException
     */
    protected function parseUri()
    {
        $routeInfo = $this->routeDispatcher->dispatch($this->request->getMethod(), $this->request->getRequestUri());
        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                $this->controller = $routeInfo[1];
                $this->controllerArgs = $routeInfo[2];
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedException($this->request->getMethod());
                break;
            case Dispatcher::NOT_FOUND:
            default:
                throw new NofFoundException();
                break;
        }
    }

    /**
     * 添加全局中间件
     *
     * @param $middleware
     * @return $this
     */
    public function addMiddleware($middleware)
    {
        $this->middleware[] = $middleware;

        return $this;
    }

    /**
     * 处理请求中间件
     *
     * @return void
     */
    protected function callMiddleware()
    {
        $firstStack = function ($request) {
            return (function ($request) {
                $this->container['response'] = $this->response = (new Response())->prepare($request);
                $this->container['originContent'] = call_user_func_array($this->controller, $this->controllerArgs);
                return $this->response;
            })($request);
        };

        /* 构造中间件 */
        $middleware = $this->registerMiddleware();

        $slice = function ($stack, $pipe) {
            return function ($request) use ($stack, $pipe) {
                /** @var Middleware $pipe */
                return call_user_func_array([$pipe, 'handle'], [$request, $stack]);
            };
        };

        call_user_func(array_reduce($middleware, $slice, $firstStack), $this->request);
    }

    /**
     * 获取请求中间件实例
     *
     * @return Middleware[]
     */
    protected function registerMiddleware()
    {
        $middleware = array_filter(array_map(function ($alias) {
            if (isset($this->config->get('middleware')[$alias])) {
                $middleware = $this->config->get('middleware')[$alias];
                return new $middleware();
            }
            return null;
        }, array_reverse(array_merge($this->controller->middleware(), $this->middleware))));

        return $middleware;
    }
}