<?php

namespace App\Api\Exception;

use App\Base\Exception;
use Symfony\Component\HttpFoundation\Response;

class MethodNotAllowedException extends Exception
{
    /**
     * 默认模板
     *
     * @var string
     */
    const TEMPLATE = "Method: '%s' Not Allowed";

    /**
     * {@inheritDoc}
     */
    public function __construct($method, $info = '')
    {
        /* code：405 */
        $this->code = Response::HTTP_METHOD_NOT_ALLOWED;
        $this->message = sprintf(self::TEMPLATE, $method);

        parent::__construct($this->message, $this->code, $info);
    }
}
