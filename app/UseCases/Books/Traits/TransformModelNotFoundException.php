<?php

namespace App\UseCases\Books\Traits;

use App\Exceptions\ResourceNotFoundException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait TransformModelNotFoundException {
    protected function onError(Exception $e): Exception|ResourceNotFoundException|false {
        if ($e instanceof ModelNotFoundException) {
            $resource = basename(
                str_replace('\\', '/', $e->getModel())
            );

            return new ResourceNotFoundException($resource, $e->getIds());
        }

        return $e;
    }
}