<?php

namespace App\Api\Exception;

use App\Base\Exception;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends Exception
{
    /**
     * 默认模板
     *
     * @var string
     */
    const TEMPLATE = "Page Not Found";

    /**
     * {@inheritDoc}
     */
    public function __construct($info = '')
    {
        /* code：404 */
        $this->code = Response::HTTP_NOT_FOUND;
        $this->message = self::TEMPLATE;

        parent::__construct($this->message, $this->code, $info);
    }
}
