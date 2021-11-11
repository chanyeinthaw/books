<?php

use App\Exceptions\GeneralException;
use JetBrains\PhpStorm\Pure;
use JetBrains\PhpStorm\ArrayShape;

if (!function_exists('serialize_exception')) {
    #[Pure]
    #[ArrayShape(['message' => "", 'code' => "string",'details' => "mixed"])]
    function serialize_exception(Exception|GeneralException $e): array {
        if ($e instanceof GeneralException) {
            return $e->toArray();
        }

        return [
            'message' => $e->getMessage(),
            'code' => 'UNHANDLED_EXCEPTION',
            'details' => $e->getTrace()
        ];
    }
}