<?php

namespace Tests\Unit;

use App\UseCases\CoverImage\StoreCoverImageUseCase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StoreCoverImageUseCaseTest extends TestCase
{
    private UploadedFile $fakeCoverImage;
    private StoreCoverImageUseCase $storeCoverImage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeCoverImage = UploadedFile::fake()->create('image.jpg', 5120, 'image/jpg');
        $this->storeCoverImage = new StoreCoverImageUseCase();
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_store_cover_image_should_success()
    {
        $url = $this->storeCoverImage->run($this->fakeCoverImage);
        $this->getMockedDisk()->assertExists('covers/' . basename($url));
    }

    public function test_store_cover_image_as_name_should_success() {
        $this->storeCoverImage->storeAs('pre-defined-name.jpg');

        $url = $this->storeCoverImage->run($this->fakeCoverImage);

        $this->getMockedDisk()->assertExists('covers/' . basename($url));
    }
}
