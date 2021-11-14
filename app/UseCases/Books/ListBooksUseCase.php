<?php

namespace App\UseCases\Books;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Lib\UseCase;

class ListBooksUseCase extends UseCase {
    protected function handler(mixed $input): LengthAwarePaginator {
        /**
         * @var ?string $input;
         */

        $bookQuery = Book::query();
        if ($input) {
            $search = "%$input%";
            $bookQuery->where('title', 'LIKE', $search)
                ->orWhere('author', 'LIKE', $search);
        }

        return $bookQuery->paginate();
    }
}