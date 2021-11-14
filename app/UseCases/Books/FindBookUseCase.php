<?php

namespace App\UseCases\Books;

use App\Models\Book;
use App\UseCases\Books\Traits\TransformModelNotFoundException;
use Lib\UseCase;

class FindBookUseCase extends UseCase {
    use TransformModelNotFoundException;

    protected function handler(mixed $input): Book {
        /**
         * @var int $input;
         */

        return Book::findOrFail($input);
    }
}