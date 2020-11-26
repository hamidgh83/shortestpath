<?php

namespace Application\Controller;

use Application\Core\Response;
use Application\Exception\BadRequestException;
use Application\Service\RoutesRepository;
use Application\Service\SearchService;

class FlightController extends AbstractController
{
    public function get()
    {
        $origin      = $this->getRequest()->getQueryParam('org');
        $destination = $this->getRequest()->getQueryParam('dst');
        $repository  = $this->getService(RoutesRepository::class);
        $service     = $this->getService(SearchService::class, $repository);
        
        if (!$origin || !$destination) {
            throw new BadRequestException();
        }

        $result = $service->shortestPath($origin, $destination);

        return new Response(['items' => $result]);
    }
}
