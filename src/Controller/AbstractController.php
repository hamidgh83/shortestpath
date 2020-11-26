<?php

namespace Application\Controller;

use Application\Core\HttpRequest;
use Application\Core\Response;
use RuntimeException;

Abstract class AbstractController
{
    private $request;

    public function __construct(HttpRequest $request)
    {
        $this->request = $request;    
    }

    public function getRequest()
    {
        return $this->request;
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

    protected function getService(string $service, ...$options)
    {
        if (!class_exists($service)) {
            throw new RuntimeException(sprintf("The class %s does not exist.", $service), 500);
        }

        return new $service(...$options);
    }

    public function __call($name, $arguments)
    {
        $this->setStatusCode(405);
        return new Response([], 'This method has not been implemented.');
    } 

}
