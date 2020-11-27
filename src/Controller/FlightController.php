<?php

namespace Application\Controller;

use Application\Core\Response;
use Application\Exception\BadRequestException;
use Application\Service\RoutesRepository;
use Application\Service\SearchService;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Flight API", version="1.0.0", contact={"email": "h.ghorashi@gmail.com"}),
 */
class FlightController extends AbstractController
{
    /**
     * @OA\Get(
     *     path="/flight",
     *     @OA\Parameter(
     *         required=true,
     *         name="org",
     *         in="query", 
     *         description="Origin IATA code"
     *     ),
     *     @OA\Parameter(
     *         required=true,
     *         name="dst",
     *         in="query", 
     *         description="Destination IATA code"
     *     ),
     *     @OA\Response(response="200", description="Operation successfull"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */
    public function get()
    {
        $origin      = strtoupper($this->getRequest()->getQueryParam('org'));
        $destination = strtoupper($this->getRequest()->getQueryParam('dst'));
        $repository  = $this->getService(RoutesRepository::class);
        $service     = $this->getService(SearchService::class, $repository);
        
        if (!$origin || !$destination) {
            throw new BadRequestException();
        }

        $result = $service->shortestPath($origin, $destination);

        return new Response(['items' => $result]);
    }
}
