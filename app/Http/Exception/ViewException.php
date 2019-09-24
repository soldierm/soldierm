<?php

namespace App\Http\Exception;

class ViewException extends Exception
{
    /**
     * {@inheritDoc}
     */
    public function __construct($message, $info = '')
    {
        parent::__construct($message, $this->code, $info);
    }
}
