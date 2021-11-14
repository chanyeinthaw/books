<?php

use App\Exceptions\GeneralException;
use Illuminate\Pagination\LengthAwarePaginator;
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

if (!function_exists('reformat_paginator_output')) {
    function reformat_paginator_output(LengthAwarePaginator $paginator, string $key = 'data'): array
    {
        $paginatedData = $paginator->toArray();
        $data = $paginatedData['data'];

        unset($paginatedData['data']);
        return [
            $key => $data,
            'meta' => $paginatedData
        ];
    }
}