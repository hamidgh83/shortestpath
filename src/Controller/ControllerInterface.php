<?php

namespace Application\Controller;

use Application\Core\HttpRequest;

interface ControllerInterface
{
    public function getRequest(): HttpRequest;

    
}