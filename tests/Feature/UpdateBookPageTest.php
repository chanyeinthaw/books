<?php

namespace Tests\Feature;

use App\UseCases\CoverImage\StoreCoverImageUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\Assert;
use Tests\TestCase;

class UpdateBookPageTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    private bool $seed = true;

    public function test_can_view_update_book_page()
    {
        $response = $this->get('/1/edit');

        $response
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Create')
                    ->has('book')
            );
    }

    public function test_can_update_book()
    {
        $this->spy(StoreCoverImageUseCase::class)
            ->shouldReceive('run')
            ->andReturn(true);

        $this->followingRedirects()->patch('/1/edit', [
            'title' => $this->faker->city(),
            'image' => UploadedFile::fake()->image('image.png')
        ])->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Book')
                    ->where('flash.message', 'Book updated!')
            );
    }

    public function test_should_get_error_if_invalid_book_id_is_given()
    {
        $this->followingRedirects()->from('/')->get('/100/edit', [
            'title' => 'Abc'
        ])->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Index')
                    ->where('flash.error.code', 'Book.InvalidId')
            );
    }

    public function test_should_get_error_if_invalid_arguments_are_given()
    {
        $this->followingRedirects()
            ->from('/1/edit')->patch('/1/edit', [
            'title' => 1,
            'image' => 1
        ])->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Create')
                    ->has('errors')
            );
    }

    public function test_should_get_error_if_image_update_fails()
    {
        $this->spy(StoreCoverImageUseCase::class)
            ->shouldReceive('run')
            ->andReturn(false);

        $this->followingRedirects()
            ->from('/1/edit')->patch('/1/edit', [
                'image' => UploadedFile::fake()->image('image.png')
            ])->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Create')
                    ->where('flash.error.code', 'Image.FailToUpload')
            );
    }
}
