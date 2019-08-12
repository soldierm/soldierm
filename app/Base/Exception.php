<?php

namespace App\Base;

use Exception as PHPException;
use JsonSerializable;

abstract class Exception extends PHPException implements JsonSerializable
{
    /**
     * 详细错误信息
     *
     * @var mixed
     */
    protected $info;

    /**
     * {@inheritDoc}
     */
    public function __construct($message, $code, $info = null)
    {
        parent::__construct($message, $code);
        $this->info = $info;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return http_format($this->getCode(), $this->getMessage(), $this->getInfo());
    }

    /**
     * 获取详细错误信息
     *
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
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