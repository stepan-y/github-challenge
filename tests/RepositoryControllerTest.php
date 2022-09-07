<?php

declare(strict_types=1);

namespace Tests;

use App\Controllers\RepositoryController;

class RepositoryControllerTest
{
    private string $username = '';

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function canListRepositories(): void
    {

        echo "Running canListRepositories test.\n";
        $response = RepositoryController::index($this->username);
        $decoded_response = json_decode($response);
        if ($decoded_response
            && property_exists($decoded_response, 'username')
            && $decoded_response->username === $this->username) {
            echo "Response is successful.\n";
            return;
        }
        echo "Something went wrong. The response: $response\n";
    }

    public function cannotListRepositories(): void
    {
        echo "Running cannotListRepositories test.\n";
        $response = RepositoryController::index('');
        $decoded_response = json_decode($response);
        if ($decoded_response
            && property_exists($decoded_response, 'code')
            && $decoded_response->code === 404) {
            echo "Test completed successfully. Failure is catched. Here is the message: $decoded_response->data \n";
            return;
        }
        echo "Test failed. Here is the response: $response\n";
    }
}