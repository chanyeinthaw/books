<?php

namespace App\Http\Handlers\Books;

use App\UseCases\Books\ListBooksUseCase;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator as V;
use Inertia\Response;
use JetBrains\PhpStorm\Pure;
use Lib\RequestHandler;

class IndexPageHandler extends RequestHandler {
    protected string $component = 'Books/Index';

    #[Pure] public function __construct(
        Request $request,
        private ListBooksUseCase $listBooks
    ) {
        parent::__construct($request);
    }

    protected function validator(): Validator
    {
        return V::make($this->request->query(), [
            'query' => 'string',
        ]);
    }

    protected function handler(mixed $input) : Response
    {
        $query = $this->request->query('query');

        /** @var LengthAwarePaginator $books */
        $books = $this->listBooks->run($query);

        return $this->createInertiaRenderResponse(
            reformat_paginator_output($books, 'books')
        );
    }
}