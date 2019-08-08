<?php

namespace App\Http;

use App\Base\Controller;
use App\Http\Middleware\Middleware;
use Exception as PHPException;
use App\Base\App as BaseApp;
use App\Base\Exception;
use App\Http\Exception\MethodNotAllowedException;
use App\Http\Exception\NofFoundException;
use App\Http\Exception\UnknownException;
use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exception\JsonResponseHandle;
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
        $this->container['response'] = $this->response = new Response();
        $this->container['routeDispatcher'] = $this->routeDispatcher = simpleDispatcher($this->getConfig()->get('route'));
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        try {
            $this->parseUri();
            $content = http_format(Response::HTTP_OK, 'ok', call_user_func_array($this->controller, $this->controllerArgs));
        } catch (Exception $exception) {
            $content = $exception;
        } catch (PHPException $exception) {
            $content = new UnknownException($exception->getMessage());
        }
        $this->sendResponse($content);
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
     * 发送请求
     *
     * @param array $content
     */
    protected function sendResponse($content)
    {
        /* 暂时只提供json接口 */
        $this->response->headers->set('Content-type', 'application/json;charset=UTF-8');
        $this->response->setContent(json_encode($content))
            ->send();
        exit;
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

    protected function callMiddleware($destination)
    {
        $firstStack = function ($passable) use ($destination) {
            return $destination($passable);
        };

        /* 倒置中间件数组 */
        $pipes = array_reverse($this->middleware);

        $slice = function ($stack, $pipe) {
            return function ($request) use ($stack, $pipe) {
                /** @var Middleware $pipe */
                return call_user_func_array([$pipe, 'handle'], [$request, $stack]);
            };
        };

        $run = array_reduce($pipes, $slice, $firstStack);

        return call_user_func($run, $this->request);
    }

    /**
     * 获取请求中间件实例
     *
     * @return Middleware[]
     */
    protected function mergeMiddleware()
    {
        $middleware = array_merge($this->middleware, $this->controller->middleware());
        $middleware = array_filter(array_map(function ($alias) {
            if (isset($this->config->get('middleware')[$alias])) {
                return new($this->config->get('middleware')[$alias]);
            }
            return null;
        }, $middleware));

        return $middleware;
    }
}