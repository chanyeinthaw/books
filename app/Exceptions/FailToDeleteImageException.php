<?php

namespace App\Exceptions;


class FailToDeleteImageException extends GeneralException {
    protected $message = 'Fail to delete image.';
    protected string $errorCode = 'Image.FailToDelete';
}
