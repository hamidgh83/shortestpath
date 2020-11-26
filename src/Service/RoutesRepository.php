<?php

namespace Application\Service;

class RoutesRepository extends AbstractService
{
    public function findAllRoutes($page = 1, $pageSize = 100)
    {
        return $this->getDatabaseManager()->routes()->paged($pageSize, $page);
    }
    
    public function findConnectedAirports($airport, $excludeItems = [])
    {
        if (!empty($excludeItems)) {
            $excludeItems = ['dst' => $excludeItems];
        }
     
        return $this->getDatabaseManager()->routes()->where(['src' => $airport])->whereNot($excludeItems);
    }
}
