<?php

namespace Application\Core;

class Application
{
    protected $request;

    public function __construct(HttpRequest $request)
    {
        $this->request = $request; 
        $this->addHeaders();
    }

    public function run()
    {
        try {
            $controller = $this->request->getController();
            $action     = $this->request->getAction();
            $response   = $controller->$action();
        
            if (!$response instanceof Response) {
                throw new \RuntimeException("Invalid response.", 500);
            }
        } catch (\Throwable $ex) {
            http_response_code($ex->getCode());
            echo new Response([], $ex->getMessage());
            return;
        }

        echo $response;
    }

    public function getController()
    {
        return $this->request->getController();
    }

    public function getAction()
    {
        return $this->request->getAction();
    }

    private function addHeaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }
}
