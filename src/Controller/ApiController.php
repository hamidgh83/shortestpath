<?php

namespace Application\Controller;

class ApiController extends AbstractController
{
    public function get()
    {
        $openapi = \OpenApi\scan(__DIR__);
        
        return $openapi->toJson();
    }
}
