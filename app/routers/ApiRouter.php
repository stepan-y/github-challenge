<?php

declare(strict_types=1);

namespace App\Routers;

use App\Enums\HttpMethod;
use App\Controllers\RepositoryController;

class ApiRouter
{
    private string $uri = '';
    private string $queryString = '';

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];

        if ($_GET['username']) {
            $this->queryString = htmlspecialchars($_GET['username']);
        }
        $this->checkUri();

        if ($_SERVER['REQUEST_METHOD'] !== strtoupper(HttpMethod::Get->value)) {
            header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed", true, 405);
            die('405 Method Not Allowed');
        }
    }

    public function checkUri(): void
    {
        if (!(preg_match('/^\/user\/repos$/', $this->uri)
            || preg_match('/^\/user\/repos[?&username]/', $this->uri)))
        {
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
            die('404 Not Found');
        }
    }

    public function getRepos(): string
    {;
        return RepositoryController::index($this->queryString);
    }
}
