<?php

declare(strict_types=1);

namespace Falcon\Http;

enum Method: string
{
    case Get = 'GET';
    case Post = 'POST';
    case Put = 'PUT';
    case Delete = 'DELETE';
    case Options = 'OPTIONS';
    case Head = 'HEAD';
    case Patch = 'PATCH';
}
