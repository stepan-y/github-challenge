<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\HttpMethod;
use App\Requests\Request;
use App\Responses\Response;

class RepositoryController
{
    public static function index($request): string
    {
        if (!self::checkQuery($request)) {
            return Response::response([
                'code' => 400,
                'data' => ['message' => 'The username field is required. Set the username in env']
            ]);
        }

        $username = $request ?: $_ENV['GITHUB_USERNAME'];
        $requestData = [
            'url' => $_ENV['USERS_URL'] . $username . DIRECTORY_SEPARATOR . 'repos'
        ];
        $response = Request::send_request(HttpMethod::Get->value, $requestData);

        if ($response && $response['code'] === 404) {
            return Response::response([
                'code' => 404,
                'data' => ['message' => 'Repositories were not found for this user']
            ]);
        }

        $formatted_response = ['username' => $username, 'repositories' => []];
        if ($response && property_exists((object)$response, "data")) {
            $repos = $response['data'];
            $formatted_response['repositories'] = array_map(function ($repo) {
                return (object)[
                    'full_name' => $repo['full_name'],
                    'url' => $repo['html_url']
                ];
            }, $repos);
        }

        return json_encode($formatted_response);
    }

    private static function checkQuery(string $query): bool
    {
        return ($query || isset($_ENV['GITHUB_USERNAME']));
    }
}