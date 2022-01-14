<?php

use App\Controller\HelloController;
use App\Htpp\Response;

require_once __DIR__ . "/vendor/autoload.php";

$controller = new HelloController();
$response = $controller->hello();

$response->sendResponse();
