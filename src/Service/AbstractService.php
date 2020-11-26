<?php

namespace Application\Service;

use LessQL\Database;

class AbstractService
{
    private $dbManager;

    public function getDatabaseManager()
    {
        return $this->dbManager;
    }

    public function setDatabaseManager(Database $dbManager)
    {
        $this->dbManager = $dbManager;

        return $this;
    }
}
