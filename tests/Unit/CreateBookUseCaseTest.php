<?php

namespace Tests\Unit;


use App\Exceptions\FailToUploadImageException;
use App\UseCases\Books\CreateBookUseCase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\MockedImageUseCases;

class CreateBookUseCaseTest extends TestCase
{
    use RefreshDatabase;
    use MockedImageUseCases;

    private CreateBookUseCase $createBook;

    protected function setUp(): void
    {
        parent::setUp();

        list($storeImage, $deleteImage) = $this->createImageMocks();

        $this->createBook = new CreateBookUseCase(
            $storeImage,
            $deleteImage,
        );
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_book_should_success()
    {
        $book = $this->createBook->run([
            'title' => 'Title',
            'author' => 'Author',
            'description' => 'Description',
            'image' => $this->fakeImageSuccess
        ]);

        $this->assertModelExists($book);
    }

    public function test_create_book_should_fail_with_query_exception() {
        $this->expectException(QueryException::class);
        $this->createBook->run([
            'image' => $this->fakeImageSuccess
        ]);
    }

    public function test_create_book_should_fail_without_image_in_input_array() {
        $this->expectErrorMessage('Undefined array key "image"');
        $this->createBook->run([]);
    }

    public function test_create_book_should_throw_fail_to_upload_image_exception() {
        $this->expectException(FailToUploadImageException::class);
        $this->createBook->run([
            'title' => 'Title',
            'author' => 'Author',
            'description' => 'Description',
            'image' => $this->fakeImageFail
        ]);
    }
}
