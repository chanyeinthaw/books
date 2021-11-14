<?php

namespace App\Http\Handlers\Books;

use App\UseCases\Books\FindBookUseCase;
use Illuminate\Http\Request;
use Inertia\Response;
use JetBrains\PhpStorm\Pure;
use Lib\RequestHandler;

class RenderUpdateBookHandler extends RequestHandler {
    protected bool $backOnError = true;
    protected string $component = 'Books/Create';

    #[Pure] public function __construct(
        Request $request,
        private FindBookUseCase $findBook,
    ) {
        parent::__construct($request);
    }

    protected function handler(mixed $input): Response
    {
        $book = $this->findBook->run($input);

        return $this->createInertiaRenderResponse([
            'book' => $book
        ]);
    }
}