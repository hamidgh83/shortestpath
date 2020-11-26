<?php

namespace Application\Service;

use LessQL\Database;

interface ServiceInterface
{
    public function getDatabaseManager();
    
    public function setDatabaseManager(Database $dbManager);
}