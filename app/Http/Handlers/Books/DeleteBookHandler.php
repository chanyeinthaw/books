<?php

namespace App\Http\Handlers\Books;

use App\UseCases\Books\DeleteBookUseCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Lib\RequestHandler;

class DeleteBookHandler extends RequestHandler {
    protected ?string $redirectTo = '/';

    #[Pure] public function __construct(
        Request $request,
        private DeleteBookUseCase $deleteBook
    )
    {
        parent::__construct($request);
    }

    protected function handler(mixed $input): RedirectResponse
    {
        $this->deleteBook->run($input);

        return redirect($this->redirectTo)
            ->with('message', 'Book deleted!');
    }
}