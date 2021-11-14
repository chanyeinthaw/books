<?php

namespace Tests\Unit;

use App\Exceptions\ResourceNotFoundException;
use App\UseCases\Books\FindBookUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindBookUseCaseTest extends TestCase
{
    use RefreshDatabase;

    private bool $seed = true;
    private FindBookUseCase $findBook;

    protected function setUp(): void
    {
        parent::setUp();

        $this->findBook = new FindBookUseCase();
    }

    public function test_find_book_should_success()
    {
        $book = $this->findBook->run(1);

        $this->assertModelExists($book);
    }

    public function test_find_book_should_throws_resource_not_found_exception() {
        $this->expectException(ResourceNotFoundException::class);

        $this->findBook->run(100);
    }
}
