<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ResponseException extends Exception
{
    public static function handle($httpCode)
    {
        if ($httpCode !== Response::HTTP_OK) {
            throw new ResponseException('Unsuccessful HTTP Code Response: ' . $httpCode);
        }
    }
}
