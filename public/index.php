<?php

require_once '../vendor/autoload.php';
require_once '../bootstrap.php';

use App\Routers\ApiRouter;
header('Content-Type: application/json;charset=utf-8;');

$router = new ApiRouter();
echo($router->getRepos());
