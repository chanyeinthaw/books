<?php

namespace Tests\Traits;

use App\Exceptions\FailToUploadImageException;
use App\UseCases\CoverImage\DeleteCoverImageUseCase;
use App\UseCases\CoverImage\StoreCoverImageUseCase;
use Illuminate\Http\UploadedFile;
use Mockery;
use Mockery\MockInterface;

trait MockedImageUseCases {
    protected UploadedFile $fakeImageSuccess, $fakeImageFail;

    protected function createImageMocks(): array
    {
        $this->fakeImageSuccess = UploadedFile::fake()->create('image.jpg', 5120, 'image/jpg');
        $this->fakeImageFail = UploadedFile::fake()->create('image.png', 5120, 'image/png');

        $storeImage = $this->instance(
            StoreCoverImageUseCase::class,
            Mockery::mock(StoreCoverImageUseCase::class, function (MockInterface $mock) {
                $mock->shouldReceive('run')
                    ->with($this->fakeImageSuccess)
                    ->andReturn('https://www.fake.com/image.png');

                $mock->shouldReceive('run')
                    ->with($this->fakeImageFail)
                    ->andThrow(new FailToUploadImageException());

                $mock->shouldReceive('storeAs');
            })
        );

        $deleteImage = $this->instance(
            DeleteCoverImageUseCase::class,
            Mockery::mock(DeleteCoverImageUseCase::class, function (MockInterface $mock) {
                $mock->shouldReceive('run');
            })
        );

        return [$storeImage, $deleteImage];
    }
}