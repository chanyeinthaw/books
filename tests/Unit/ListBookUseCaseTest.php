<?php

namespace Tests\Unit;

use App\Models\Book;
use App\UseCases\Books\ListBooksUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListBookUseCaseTest extends TestCase
{
    use RefreshDatabase;

    private bool $seed = true;
    private ListBooksUseCase $listBook;

    protected function setUp(): void
    {
        parent::setUp();

        $this->listBook = new ListBooksUseCase();
    }

    public function test_list_book_should_success()
    {
        $paginatedData = $this->listBook->run([]);

        $this->assertCount(10, $paginatedData->all());
    }

    public function test_list_book_should_be_able_to_find_by_title()
    {
        $book = Book::first();
        list($query) = explode(' ', $book->title);

        $paginatedData = $this->listBook->run([
            'query' => $query
        ]);

        $this->assertGreaterThanOrEqual(1, count($paginatedData->all()));
    }

    public function test_list_book_should_be_able_to_find_by_author()
    {
        $book = Book::first();
        list($query) = explode(' ', $book->author);

        $paginatedData = $this->listBook->run([
            'query' => $query
        ]);

        $this->assertGreaterThanOrEqual(1, count($paginatedData->all()));
    }

    public function test_list_book_should_be_able_to_sort_by_title() {
        $books = Book::query()->orderBy('title')->paginate();

        $paginatedData = $this->listBook->run([
            'sortBy' => 'title'
        ]);

        $this->assertEquals($books, $paginatedData);
    }

    public function test_list_book_should_be_able_to_sort_by_author() {
        $books = Book::query()->orderBy('author')->paginate();

        $paginatedData = $this->listBook->run([
            'sortBy' => 'author'
        ]);

        $this->assertEquals($books, $paginatedData);
    }

    public function test_list_book_should_be_able_to_change_sorting_direction() {
        $books = Book::query()->orderBy('title', 'desc')->paginate();

        $paginatedData = $this->listBook->run([
            'sortBy' => 'title',
            'direction' => 'desc'
        ]);

        $this->assertEquals($books, $paginatedData);
    }

    public function test_list_book_should_not_return_books_for_invalid_title_or_author()
    {
        $paginatedData = $this->listBook->run([
            'query' => '```'
        ]);

        $this->assertCount(0, $paginatedData->all());
    }
}
