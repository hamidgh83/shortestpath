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

    public function getQueryParam($param)
    {
        return $_GET[$param] ?? null;
    }

    public function getController()
    {
        $namespace  = '\Application\Controller\\';
        $controller = (isset($this->uri[1]) && strlen(trim($this->uri[1])) > 0 ? $this->uri[1] : 'Default') . 'Controller';
        $controller = $namespace . ucfirst($controller);

        if (!class_exists($controller)) {
            throw new NotFoundException();
        }

        return new $controller($this);
    }
    
    public function getAction()
    {
        $action = null;

        switch ($this->requestMethod) {
            case 'GET':
                $action = 'get';
                break;
            case 'POST':
                $action = 'create';
                break;
            case 'PUT':
                $action = 'update';
                break;
            case 'DELETE':
                $action = 'delete';
                break;
            default:
                $action = 'options';
                break;
        }

        return $action;
    }

    private function process()
    {
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];

        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->uri = explode('/', $this->uri);
    }
}
