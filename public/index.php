<?php

// TODO Load project environment from .env file 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use Application\Core\HttpRequest;
use Application\Core\Application;

$request = new HttpRequest;
$app     = new Application($request);

$app->run();
