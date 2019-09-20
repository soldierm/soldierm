<?php

namespace App\Api\Exception;

use App\Base\Exception;

class UnknownException extends Exception
{
    /**
     * 默认模板
     *
     * @var string
     */
    const TEMPLATE = "Something Went Wrong";

    /**
     * 未知错误
     *
     * @var int
     */
    const CODE = 999;

    /**
     * {@inheritDoc}
     */
    public function __construct($info = '')
    {
        /* code：404 */
        $this->code = self::CODE;
        $this->message = self::TEMPLATE;

        parent::__construct($this->message, $this->code, $info);
    }
}
