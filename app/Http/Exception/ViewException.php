<?php

namespace App\Http\Exception;

use App\Base\Exception;
use Symfony\Component\HttpFoundation\Response;

class ViewException extends Exception
{
    /**
     * 默认模板
     *
     * @var string
     */
    const TEMPLATE = "Action Not Allowed";

    /**
     * {@inheritDoc}
     */
    public function __construct($method, $info = '')
    {
        /* code：401 */
        $this->code = Response::HTTP_UNAUTHORIZED;
        $this->message = self::TEMPLATE;

        parent::__construct($this->message, $this->code, $info);
    }
}
