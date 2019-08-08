<?php

namespace App\Http\Exception;

use Whoops\Handler\Handler;
use Whoops\Handler\JsonResponseHandler as BaseJsonResponseHandler;

class JsonResponseHandle extends BaseJsonResponseHandler
{
    /**
     * {@inheritDoc}
     */
    public function handle()
    {
        $response = http_format(UnknownException::CODE, $this->getInspector()->getException()->getMessage(), '');

        echo json_encode($response, defined('JSON_PARTIAL_OUTPUT_ON_ERROR') ? JSON_PARTIAL_OUTPUT_ON_ERROR : 0);

        return Handler::QUIT;
    }
}