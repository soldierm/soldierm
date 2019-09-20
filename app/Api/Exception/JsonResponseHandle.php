<?php

namespace App\Api\Exception;

use Whoops\Handler\Handler;
use Whoops\Handler\JsonResponseHandler as BaseJsonResponseHandler;

class JsonResponseHandle extends BaseJsonResponseHandler
{
    /**
     * {@inheritDoc}
     */
    public function handle()
    {
        $exception = $this->getInspector()->getException();

        $response = http_format($exception->getCode(), $exception->getMessage(), '');

        echo json_encode($response, defined('JSON_PARTIAL_OUTPUT_ON_ERROR') ? JSON_PARTIAL_OUTPUT_ON_ERROR : 0);

        return Handler::QUIT;
    }
}
