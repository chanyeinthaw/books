<?php

namespace App\UseCases\Books;

use App\Models\Book;
use App\UseCases\UseCase;
use Illuminate\Database\Eloquent\Collection;

class ListBooksUseCase extends UseCase {
    protected function handler(mixed $input): array|Collection{
        /**
         * @var ?string $query;
         * @var ?int $skip
         * @var ?int $limit
         */
        extract($input);

        if (!isset($skip)) $skip = 0;
        if (!isset($limit)) $limit = 16;

        $bookQuery = Book::query();
        if (isset($query)) {
            $search = "%$query%";
            $bookQuery->where('title', 'LIKE', $search)
                ->orWhere('author', 'LIKE', $search);
        }

        return $bookQuery->offset($skip)->limit($limit)->get();
    }
}