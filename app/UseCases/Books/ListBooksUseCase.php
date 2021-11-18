<?php

namespace App\UseCases\Books;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Lib\UseCase;

class ListBooksUseCase extends UseCase {
    protected function handler(mixed $input): LengthAwarePaginator {
        /**
         * @var ?string $query;
         * @var ?string $sortBy;
         * @var ?string $direction;
         */
        extract($input);

        $bookQuery = Book::query();
        if (isset($query)) {
            $search = "%$query%";
            $bookQuery->where('title', 'LIKE', $search)
                ->orWhere('author', 'LIKE', $search);
        }

        if (isset($sortBy) && $sortBy !== 'default') {
            $bookQuery->orderBy($sortBy, $direction ?? 'asc');
        } else {
            $bookQuery->orderBy('id', $direction ?? 'asc');
        }

        return $bookQuery->paginate();
    }
}