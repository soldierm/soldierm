<?php

namespace App\Api\Exception;

use App\Base\Exception as BaseException;
use JsonSerializable;

abstract class Exception extends BaseException implements JsonSerializable
{
    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        container()->response->headers->set('Content-type', 'application/json;charset=UTF-8');

        return http_format($this->getCode(), $this->getMessage(), $this->getInfo());
    }

    /**
     * 异常抛出
     *
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }
}
