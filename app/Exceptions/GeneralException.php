<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\ArrayShape;

abstract class GeneralException extends Exception {
    protected string $errorCode;

    protected mixed $details = null;

    #[ArrayShape(['message' => "", 'code' => "string",'details' => "mixed"])]
    public function toArray(): array {
        return [
            'message' => $this->message,
            'code' => $this->errorCode,
            'details' => $this->details
        ];
    }
}