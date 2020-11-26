<?php

namespace Application\Core;

use Application\Exception\NotFoundException;

class HttpRequest
{
    private $uri;

    private $requestMethod;

    public function __construct()
    {
        $this->process();
    }

    public function getMethod() 
    {
        return $this->requestMethod;
    }

    public function getUri() 
    {
        return $this->uri;
    }

    public function getQueryParams()
    {
        return $_GET;
    }

    public function getQueryParam($param, $default = null)
    {
        return $_GET[$param] ?? $default;
    }

    private function process()
    {
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];

        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->uri = explode('/', $this->uri);
    }
}
