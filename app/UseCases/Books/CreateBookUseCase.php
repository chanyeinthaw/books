<?php

namespace App\UseCases\Books;

use App\Exceptions\FailToUploadImageException;
use App\Models\Book;
use App\UseCases\CoverImage\DeleteCoverImageUseCase;
use App\UseCases\CoverImage\StoreCoverImageUseCase;
use App\UseCases\UseCase;
use Exception;

class CreateBookUseCase extends UseCase {
    private ?string $coverImageURL = null;
    public function __construct(
        protected StoreCoverImageUseCase $storeCoverImage,
        protected DeleteCoverImageUseCase $deleteCoverImage
    ) { }

    /**
     * @throws FailToUploadImageException
     */
    protected function handler(mixed $input): Book {
        $this->coverImageURL = $this->storeCoverImage->run($input['image']);
        if (!$this->coverImageURL) throw new FailToUploadImageException();

        $input['image'] = $this->coverImageURL;

        return Book::create($input);
    }

    protected function onError(Exception $e): Exception|false {
        if ($this->coverImageURL) {
            $this->deleteCoverImage->run($this->coverImageURL);
        }

        return parent::onError($e);
    }
}