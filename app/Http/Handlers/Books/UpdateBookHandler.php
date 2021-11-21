<?php

namespace App\Http\Handlers\Books;

use App\UseCases\Books\UpdateBookUseCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator as V;
use JetBrains\PhpStorm\Pure;
use Lib\RequestHandler;

class UpdateBookHandler extends RequestHandler {
    protected bool $backOnError = true;
    protected ?string $redirectTo = '/';

    #[Pure] public function __construct(
        Request $request,
        private UpdateBookUseCase $updateBook
    ) {
        parent::__construct($request);
    }

    protected function validator(): Validator
    {
        return V::make($this->request->all(), [
            'title' => 'string',
            'author' => 'string',
            'description' => 'string',
            'image' => 'image'
        ]);
    }

    /**
     * @throws ValidationException
     */
    protected function handler(mixed $input) : RedirectResponse
    {
        $data = $this->validator->validated();

        $this->updateBook->run([
            'bookId' => $input,
            'partial' => $data
        ]);

        return redirect($this->redirectTo . "$input")
            ->with('message', 'Book updated!');
    }
}