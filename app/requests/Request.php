<?php

declare(strict_types=1);

namespace App\Requests;

use App\Responses\Response;

final class Request
{
    public static function send_request(string $method, ?array $data = null): array
    {
        return self::$method($data);
    }

    private static function post(array $data = []): array
    {
        $curl = self::make_curl($data['url']);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data['data']));

        return self::execute($curl);
    }

    private static function delete(array $data = []): array
    {
        $curl = self::make_curl($data['url']);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

        return self::execute($curl);
    }

    private static function get(array $data = []): array
    {
        $curl = self::make_curl($data['url']);
        return self::execute($curl);
    }

    private static function make_curl(string $uri): \CurlHandle|bool
    {
        $curl = curl_init($uri);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/vnd.github.v3+json',
            'Authorization: token ' . $_ENV['GITHUB_PERSONAL_TOKEN'],
            'Content-Type: application/json',
            'User-Agent: Github-Api-Challenge'
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        return $curl;
    }

    private static function execute(\CurlHandle $curl): array
    {
        $response = curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        if (curl_error($curl)){
            echo("CURL error!\n");
            echo(curl_error($curl));
            die("\nExit");
        }

        return ['code' => $responseCode, 'data' => json_decode($response, true)];
    }
}