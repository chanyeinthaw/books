<?php

namespace App\UseCases\CoverImage;

use Illuminate\Support\Facades\Storage;

class DeleteCoverImageUseCase extends CoverImageBase {
    protected function handler(mixed $input) : bool {
        /** @var string $input */

        return Storage::disk('s3')->delete($this->getPathFromURL($input));
    }
}