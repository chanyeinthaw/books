<?php

namespace App\UseCases\CoverImage;

use Illuminate\Support\Facades\Storage;

class DeleteCoverImageUseCase extends CoverImageBase {
    protected function handler(mixed $input) : bool {
        /** @var string $input */

        return Storage::disk(env('FILESYSTEM_DRIVER'))->delete($this->getPathFromURL($input));
    }
}