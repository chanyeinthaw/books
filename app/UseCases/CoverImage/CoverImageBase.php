<?php
namespace App\UseCases\CoverImage;

use App\UseCases\UseCase;

abstract class CoverImageBase extends UseCase {
    protected string $directory;

    public function __construct() {
        $this->directory = env('COVER_IMAGE_PATH');
    }

    public function getPathFromURL(string $url): string {
        $fileName = basename($url);
        return $this->directory . "/$fileName";
    }
}