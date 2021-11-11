<?php

namespace App\UseCases\Books;

use App\Exceptions\FailToDeleteImageException;
use App\Models\Book;
use App\UseCases\CoverImage\DeleteCoverImageUseCase;
use App\UseCases\UseCase;
use App\UseCases\Books\Traits\TransformModelNotFoundException;

class DeleteBookUseCase extends UseCase {
    use TransformModelNotFoundException;

    public function __construct(
        private DeleteCoverImageUseCase $deleteImage
    ) { }

    /**
     * @throws FailToDeleteImageException
     */
    protected function handler(mixed $input): bool {
        /**
         * @var int $input;
         */

        $book = Book::findOrFail($input);
        if (!$this->deleteImage->run($book->image)) throw new FailToDeleteImageException();

        return $book->delete();
    }
}