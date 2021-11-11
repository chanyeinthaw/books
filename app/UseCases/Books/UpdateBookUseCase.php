<?php

namespace App\UseCases\Books;

use App\Exceptions\FailToUploadImageException;
use App\Models\Book;
use App\UseCases\Books\Traits\TransformModelNotFoundException;
use Illuminate\Http\UploadedFile;

class UpdateBookUseCase extends CreateBookUseCase {
    use TransformModelNotFoundException;

    protected function handler(mixed $input): Book {
        /**
         * @var Book $book;
         * @var int $bookId;
         * @var array $partial;
         */
        extract($input);

        if (!isset($book)) $book = Book::findOrFail($bookId);
        if (isset($partial['image']))
            $this->tryCoverImageUpdate($partial['image'], $book);

        unset($partial['image']);
        $book->update($partial);

        return $book;
    }

    /**
     * @throws FailToUploadImageException
     */
    private function tryCoverImageUpdate(UploadedFile $image, Book $book) {
        $this->storeCoverImage->storeAs(basename($book->image));
        $coverImageURL = $this->storeCoverImage->run($image);
        if (!$coverImageURL) throw new FailToUploadImageException();
        $book->image = $coverImageURL;
    }
}