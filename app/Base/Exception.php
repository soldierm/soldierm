<?php

namespace App\Base;

use Exception as PHPException;

abstract class Exception extends PHPException
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
     * 获取详细错误信息
     *
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }
}
