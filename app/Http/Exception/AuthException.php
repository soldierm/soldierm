<?php

namespace App\Http\Exception;

class AuthException extends Exception
{
    /**
     * 错误码
     *
     * @var int
     */
    const CODE = 500;

    /**
     * InvalidArgumentException constructor.
     * @param $message
     * @param null $info
     */
    public function __construct($message, $info = null)
    {
        parent::__construct($message, self::CODE, $info);
    }
}
