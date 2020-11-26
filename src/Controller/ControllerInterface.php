<?php

namespace Application\Controller;

use Application\Core\HttpRequest;
use Application\Service\ServiceInterface;

interface ControllerInterface
{
    public function getRequest(): HttpRequest;

    public function setStatusCode($statusCode);

    public function getService(string $service, ...$options): ServiceInterface
}