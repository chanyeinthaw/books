<?php

namespace App\Http\Handlers\Books;

use App\UseCases\Books\CreateBookUseCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator as V;
use JetBrains\PhpStorm\Pure;
use Lib\RequestHandler;

class CreateBookHandler extends RequestHandler {
    protected ?string $redirectTo = '/';
    protected bool $backOnError = true;

    #[Pure] public function __construct(
        Request $request,
        private CreateBookUseCase $createBook
    ) {
        parent::__construct($request);
    }

    protected function validator(): Validator
    {
        return V::make($this->request->all(), [
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image'
        ]);
    }

    /**
     * @throws ValidationException
     */
    protected function handler(mixed $input) : RedirectResponse
    {
        $data = $this->validator->validated();

        $this->createBook->run($data);

        return redirect($this->redirectTo)
            ->with('message', 'Book created!');
    }
}