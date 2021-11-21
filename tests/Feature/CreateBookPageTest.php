<?php

namespace Tests\Feature;

use App\UseCases\CoverImage\StoreCoverImageUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\Assert;
use Tests\TestCase;

class CreateBookPageTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_view_create_book_page()
    {
        $response = $this->get('/create');

        $response
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Create')
            );
    }

    public function test_can_create_book() {
        $this->spy(StoreCoverImageUseCase::class)
            ->shouldReceive('run')
            ->andReturn(true);

        $response = $this->followingRedirects()->post('/create', [
            'title' => $this->faker->city(),
            'author' => $this->faker->name(),
            'description' => $this->faker->sentence(30),
            'image' => UploadedFile::fake()->image('image.png')
        ]);

        $response->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Book')
                    ->where('flash.message', 'Book created!')
            );
    }

    public function test_create_book_should_get_error_if_file_upload_fails() {
        $this->spy(StoreCoverImageUseCase::class)
            ->shouldReceive('run')
            ->andReturn(false);

        $response = $this->followingRedirects()
            ->from('/create')->post('/create', [
            'title' => $this->faker->city(),
            'author' => $this->faker->name(),
            'description' => $this->faker->sentence(30),
            'image' => UploadedFile::fake()->image('image.png')
        ]);

        $response->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Create')
                    ->where('flash.error.code', 'Image.FailToUpload')
            );
    }

    public function test_create_book_should_get_error_if_validation_fails() {
        $response = $this->followingRedirects()
            ->from('/create')->post('/create', [
            'title' => $this->faker->city(),
            'author' => $this->faker->name(),
            'image' => UploadedFile::fake()->image('image.png')
        ]);

        $response->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Create')
                    ->has('errors')
            );
    }
}
