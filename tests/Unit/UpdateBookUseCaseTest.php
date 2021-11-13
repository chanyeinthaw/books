<?php

namespace Tests\Unit;


use App\Exceptions\FailToUpdateResourceException;
use App\Exceptions\FailToUploadImageException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\Book;
use App\UseCases\Books\UpdateBookUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\MockedImageUseCases;

class UpdateBookUseCaseTest extends TestCase
{
    use RefreshDatabase;
    use MockedImageUseCases;

    private bool $seed = true;
    private UpdateBookUseCase $updateBook;

    protected function setUp(): void
    {
        parent::setUp();

        list($storeImage, $deleteImage) = $this->createImageMocks();

        $this->updateBook = new UpdateBookUseCase(
            $storeImage,
            $deleteImage
        );
    }

    public function test_update_book_should_success()
    {
        $book = $this->updateBook->run([
            'bookId' => 1,
            'partial' => [
                'title' => 'Title'
            ]
        ]);

        $this->assertModelExists($book);
        $this->assertEquals('Title', $book->title);
    }

    public function test_update_book_should_success_for_existing_model() {
        $existingBook = Book::find(1);
        $book = $this->updateBook->run([
            'book' => $existingBook,
            'partial' => [
                'title' => 'Updated Title'
            ]
        ]);

        $this->assertModelExists($book);
        $this->assertEquals('Updated Title', $book->title);
    }

    public function test_update_book_should_fail_when_invalid_arguments_are_given() {
        $this->expectException(\ErrorException::class);
        $this->updateBook->run([]);
    }

    public function test_update_book_should_throw_resource_not_found_exception_when_invalid_book_id_is_given() {
        $this->expectException(ResourceNotFoundException::class);
        $this->updateBook->run([
            'bookId' => 1000
        ]);
    }

    public function test_update_book_should_throw_fail_to_update_resource_exception_when_invalid_book_model_is_given() {
        $this->expectException(FailToUpdateResourceException::class);
        $book = Book::first();
        $book->delete();

        $this->updateBook->run([
            'book' => $book,
            'partial' => [
                'title' => 'Title'
            ]
        ]);
    }

    public function test_update_book_should_throw_fail_to_upload_image_exception_when_image_upload_is_failed() {
        $this->expectException(FailToUploadImageException::class);
        $this->updateBook->run([
            'bookId' => 1,
            'partial' => [
                'image' => $this->fakeImageFail
            ]
        ]);
    }
}
