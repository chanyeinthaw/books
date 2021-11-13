<?php

namespace Tests\Unit;

use App\UseCases\CoverImage\DeleteCoverImageUseCase;
use App\UseCases\CoverImage\StoreCoverImageUseCase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DeleteCoverImageUseCaseTest extends TestCase
{
    private string $fileURL;
    private DeleteCoverImageUseCase $deleteCoverImage;

    protected function setUp(): void
    {
        parent::setUp();

        $fakeCoverImage = UploadedFile::fake()->create('image.jpg', 5120, 'image/jpg');
        $storeCoverImage = new StoreCoverImageUseCase();
        $this->fileURL = $storeCoverImage->run($fakeCoverImage);
        $this->deleteCoverImage = new DeleteCoverImageUseCase();
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_delete_cover_image_should_success()
    {
        $status = $this->deleteCoverImage->run($this->fileURL);

        $this->getMockedDisk()->assertMissing('covers/' . basename($this->fileURL));
        $this->assertTrue($status);
    }

    public function test_delete_cover_image_should_fail()
    {
        $status = $this->deleteCoverImage->run('non existent file');

        $this->assertFalse($status);
    }
}
