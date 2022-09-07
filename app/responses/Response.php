<?php

declare(strict_types=1);


namespace App\Responses;


final class Response
{
    public static function response(array $data): string
    {
        return json_encode([
            'code' => $data['code'],
            'data' => $data['data']
        ]);
    }
}