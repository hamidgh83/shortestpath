<?php

namespace Application\Service;

use LessQL\Database;

class AbstractService implements ServiceInterface
{
    /**
     * @var Database
     */
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
