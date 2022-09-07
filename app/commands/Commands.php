<?php

declare(strict_types=1);

namespace App\Commands;

use App\Requests\Request;
use App\Responses\Response;

final class Commands
{
    public static function list_repos(string $username): string
    {
        $data = [
            'url' => $_ENV['USERS_URL'] . "$username/repos"
        ];
        $response = Request::send_request('get', $data);
        $response['result'] = json_encode($response['result']);
        return Response::response($response);
    }

    public static function create_repo(string $name): string
    {
        $data = [
            'data' => [ 'name' => $name ],
            'url' => $_ENV['CREATE_URL']
        ];
        $response = Request::send_request('post', $data);
        return Response::response($response);
    }

    public static function delete_repo(string $name): string
    {
        $data = [
            'url' => $_ENV['DELETE_URL'] . $_ENV['GITHUB_USERNAME'] . "/$name"
        ];
        $response = Request::send_request('delete', $data);
        return Response::response($response);
    }

}