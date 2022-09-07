<?php

declare(strict_types=1);

namespace App\Enums;

enum HttpMethod: string
{
    case Post = "post";
    case Get = 'get';
    case Delete = 'delete';
}