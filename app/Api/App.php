<?php

namespace App\Api;

use App\Base\App as BaseApp;
use App\Base\Controller;
use App\Api\Exception\Exception;
use App\Base\Middleware;
use App\Api\Exception\JsonResponseHandle;
use App\Api\Exception\MethodNotAllowedException;
use App\Api\Exception\NotFoundException;
use App\Api\Exception\UnknownException;
use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

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
     * @var JsonResponse
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

        config('api_service')->call($this);
        config('api_bootstrap')->call($this);
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        $this->parseUri();
        $this->callMiddleware();
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
        set_exception_handler(function (Throwable $exception) {
            if ($exception instanceof Exception) {
                $this->response->setData($exception);
            } else {
                $this->response->setData(new UnknownException($exception->getMessage()));
            }
        });

        $whoops = new Run();
        if ($this->isDevMod()) {
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
     * @throws NotFoundException
     */
    protected function parseUri()
    {
        $routeInfo = $this->routeDispatcher->dispatch($this->request->getMethod(), $this->request->getPathInfo());
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
                throw new NotFoundException();
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
                $this->container['response'] = $this->response = (new JsonResponse())->prepare($request);
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
            if (isset($this->config->get('api_middleware')[$alias])) {
                $middleware = $this->config->get('api_middleware')[$alias];
                return new $middleware();
            }
            return null;
        }, array_reverse(array_merge($this->controller->middleware(), $this->middleware))));

        return $middleware;
    }

    /**
     * 是否是开发模式
     *
     * @return bool
     */
    protected function isDevMod()
    {
        return $this->container['debug'] === true;
    }
}
