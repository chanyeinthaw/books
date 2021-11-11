<?php

namespace App\Exceptions;


class FailToUploadImageException extends GeneralException {
    protected $message = 'Fail to upload image.';
    protected string $errorCode = 'Image.FailToUpload';
}