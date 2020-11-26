<?php

namespace Application\Service;

use SplDoublyLinkedList;
use SplQueue;
use Traversable;

/**
 * This class is to search the graph of data (stored in the database) and find the best shortest path between origin and destination.
 */
class SearchService extends AbstractService
{
    const INFINIT = 'INF';
    
    /**
     * Maximum layovers between origin and destination.
     */
    const MAXLEGS = 3;
    
    /**
     * The repository object to access the database.
     * 
     * @var RoutesRepository
     */
    protected $repository;

    /**
     * An array of already visited nodes.
     *  
     * @var array
     */
    protected $visited = [];

    /**
     * A queue to store result nodes.
     * 
     * @var SplQueue
     */
    protected $queue;

    /**
     * An array of distances.
     *
     * @var array
     */
    protected $d;

    /**
     * Constructor function
     *
     * @param RoutesRepository $repository
     */
    public function __construct(RoutesRepository $repository)
    {
        $this->repository = $repository;
        $this->queue      = new SplQueue;
    }

    /**
     * This gets the shortest path between origin and destination.
     *
     * @param string $origin
     * @param string $destination
     * @return array
     */
    public function shortestPath($origin, $destination)
    {
        $this->d                = [];
        $this->d[$origin]       = ['cost' => 0, 'distance' => 0, 'prev' => null];
        $this->visited[$origin] = true;

        // Push the first point to route queue
        $this->queue->push([$origin => $this->d[$origin]]);
        $this->dijkstra($origin, $destination, self::MAXLEGS);
        
        // Get all possible routes
        $routes = $this->getRoutes();
        
        return $this->getBestRoute($routes, $destination);
    }

    /**
     * Return all possible routes.
     *
     * @return array
     */
    protected function getRoutes()
    {
        $path = [];
        $this->queue->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
        for ($this->queue->rewind(); $this->queue->valid(); $this->queue->next()) {
            $route        = $this->queue->current();
            $key          = array_key_first($route);
            $path[$key][] = $route[$key];
        }

        return $path;
    }

    public function getBestRoute(array $routes, string $destination)
    {
        $bestRoute = [];
        
        while (isset($routes[$destination])) {
            $paths = $routes[$destination];
            $costs = array_column($paths, 'cost');
            $key   = array_search(min($costs), $costs);

            if ($paths[$key]['prev'] == null) {
                break;
            }

            $bestRoute[] = ['from' => $paths[$key]['prev'], 'to' => $destination, 'distance' => $paths[$key]['distance']];
            $destination = $paths[$key]['prev'];
        }
        
        return array_reverse($bestRoute);
    }

    /**
     * This implements Dijkstra algorithm to find the shortest path between nodes in a gragh.
     *
     * @param string $origin
     * @param string $destination
     * @return array
     */
    protected function dijkstra($origin, $destination, $maxLegs)
    {
        $maxLegs --;

        if ($origin == $destination) {
            return $this->d[$destination];
        }

        // Find all frontiers of $origin
        $frontiers = $this->getFrontiers($origin);

        if (empty($frontiers) || $maxLegs < 0) {
            return $this->d[$origin];
        }

        foreach ($frontiers as $vertex) {
            $vertex                        = $vertex->getData();
            $this->visited[$vertex['src']] = true;
            $value                         = $this->d[$origin]['cost'] + $vertex['distance'];
            $this->d[$vertex['dst']]['cost']     = $d[$vertex['dst']] ?? self::INFINIT;

            $this->d[$vertex['dst']]['distance'] = $vertex['distance'];
            $this->d[$vertex['dst']]['prev'] = $origin;
            
            if ($this->d[$vertex['dst']]['cost'] == self::INFINIT || $value < $this->d[$vertex['dst']]['cost']) {
                $this->d[$vertex['dst']]['cost'] = $value;
                $this->d[$vertex['dst']]['distance'] = $vertex['distance'];
                $this->d[$vertex['dst']]['prev'] = $origin;
            }

            $result = $this->dijkstra($vertex['dst'], $destination, $maxLegs);

            // Push the answer to queue
            $this->queue->push([$vertex['dst'] => $result]);
        }

        return $this->d[$origin];
    }

    /**
     * This returns all frontier nodes
     *
     * @param string $node
     * @return Traversable
     */
    protected function getFrontiers($node)
    {
        return $this->repository->findConnectedAirports($node, array_keys($this->visited));
    }
}
