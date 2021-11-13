<?php

namespace Tests\Unit;

use App\Exceptions\FailToDeleteImageException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\Book;
use App\UseCases\Books\DeleteBookUseCase;
use App\UseCases\CoverImage\DeleteCoverImageUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class DeleteBookUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;
    private DeleteBookUseCase $deleteBook;

    protected function setUp(): void
    {
        parent::setUp();

        $deleteImage = $this->instance(
            DeleteCoverImageUseCase::class,
            Mockery::mock(DeleteCoverImageUseCase::class, function (Mockery\MockInterface $mock) {
                $mock->shouldReceive('run')
                    ->with('https://via.placeholder.com/300x450.png/CCCCCC?text=foo')
                    ->andReturn(true);

                $mock->shouldReceive('run')
                    ->with('https://via.placeholder.com/300x450.png/CCCCCC?text=bar')
                    ->andReturn(false);
            })
        );

        $this->deleteBook = new DeleteBookUseCase($deleteImage);
    }

    public function test_delete_should_book_success()
    {
        $book = Book::query()->where('image', 'https://via.placeholder.com/300x450.png/CCCCCC?text=foo')
            ->first();
        $this->deleteBook->run($book->id);

        $this->assertModelMissing($book);
    }

    public function test_delete_book_should_throw_resource_not_found_exception() {
        $this->expectException(ResourceNotFoundException::class);
        $this->deleteBook->run(100);
    }

    public function test_delete_should_throw_fail_to_delete_image_exception() {
        $this->expectException(FailToDeleteImageException::class);

        $book = Book::query()->where('image', 'https://via.placeholder.com/300x450.png/CCCCCC?text=bar')
            ->first();
        $this->deleteBook->run($book->id);

        $this->assertModelExists($book);
    }
}
