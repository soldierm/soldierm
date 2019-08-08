<?php

namespace App\Http;

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
            $parsedUri = $this->parseUri();
            $content = http_format(Response::HTTP_OK, 'ok', call_user_func_array($parsedUri[0], $parsedUri[1]));
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
    protected function sendResponse($content)
    {
        /* 暂时只提供json接口 */
        $this->response->headers->set('Content-type', 'application/json;charset=UTF-8');
        $this->response->setContent(json_encode($content))
            ->send();
        exit;
    }
}