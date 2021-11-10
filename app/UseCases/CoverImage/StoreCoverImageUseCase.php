<?php

namespace App\UseCases\CoverImage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreCoverImageUseCase extends CoverImageBase {
    private ?string $name = null;

    public function storeAs(string $name) {
        $this->name = $name;
    }

    protected function handler(mixed $input) : bool|string {
        /** @var UploadedFile $input */
        if ($this->name) $path = $input->storeAs($this->directory, $this->name);
        else $path = $input->store($this->directory);

        return Storage::url($path);
    }
}