<?php

namespace Application\Controller;

use Application\Core\Response;

Abstract class AbstractController
{
    public function __call($name, $arguments)
    {
        $this->setStatusCode(405);
        return new Response([], 'This method has not been implemented.');
    } 

    public function setStatusCode($statusCode)
    {
        http_response_code($statusCode);

        return $statusCode;
    }

    public function getStatusCode()
    {
        http_response_code();
    }
}
