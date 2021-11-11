<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;

class ResourceNotFoundException extends GeneralException {
    public function __construct(string $resource, int|array $ids = []) {
        $resourceLowerCase = strtolower($resource);
        $this->errorCode = $resource . ".InvalidId";
        $this->details = $this->buildErrorDetails($resourceLowerCase, $ids);

        parent::__construct("Invalid $resourceLowerCase id");
    }

    private function buildErrorDetails(string $resource, int|array $ids): array|null {
        $count = count($ids);
        if ($count === 0) return null;

        $key = "{$resource}Id" . $count > 1 ? "s" : "";

        return [
            $key => $count === 1 ? $ids[0] : $ids
        ];
    }
}