<?php

namespace App\Http\Controllers;

use App\Http\Handlers\Books\BookPageHandler;
use App\Http\Handlers\Books\BooksExportHandler;
use App\Http\Handlers\Books\CreateBookHandler;
use App\Http\Handlers\Books\DeleteBookHandler;
use App\Http\Handlers\Books\IndexPageHandler;
use App\Http\Handlers\Books\RenderUpdateBookHandler;
use App\Http\Handlers\Books\UpdateBookHandler;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class BookController extends Controller
{
    public function __construct(
        protected IndexPageHandler $indexPage,
        protected BookPageHandler $bookPage,
        protected DeleteBookHandler $deleteBook,
        protected CreateBookHandler $createBook,
        protected UpdateBookHandler $updateBook,
        protected RenderUpdateBookHandler $renderUpdateBook,
        protected BooksExportHandler $export
    ) { }

    public function index(): Response
    {
        $this->indexPage->run(null);

        return $this->indexPage->response();
    }

    public function get($id): Response {
        $this->bookPage->run($id);

        return $this->bookPage->response();
    }

    public function delete($id): Response|\Symfony\Component\HttpFoundation\Response
    {
        $this->deleteBook->run($id);

        return $this->deleteBook->response();
    }

    public function renderCreate(): Response
    {
        return Inertia::render('Books/Create');
    }

    public function create(): Response|\Symfony\Component\HttpFoundation\Response
    {
        $this->createBook->run(null);

        return $this->createBook->response();
    }

    public function renderUpdate($id): Response|RedirectResponse
    {
        $this->renderUpdateBook->run($id);

        return $this->renderUpdateBook->response();
    }

    public function update($id): Response|\Symfony\Component\HttpFoundation\Response
    {
        $this->updateBook->run($id);

        return $this->updateBook->response();
    }

    public function export(): Response|\Symfony\Component\HttpFoundation\Response
    {
        $this->export->run(null);

        return $this->export->response();
    }
}
