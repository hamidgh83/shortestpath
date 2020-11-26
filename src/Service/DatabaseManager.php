<?php

namespace Application\Service;

use LessQL\Database;
use PDO;

class DatabaseManager
{
    private static $instance = null;

    private static $connection;
    
    private function __construct()
    {
        $path              = __DIR__ . '/../../data/airports.db';
        $pdo               = new PDO('sqlite:' . $path);
        self::$connection  = new Database($pdo);
    }
    
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new DatabaseManager();
        }
        
        return self::$connection;
    }
}
