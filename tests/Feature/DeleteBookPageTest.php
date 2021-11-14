<?php

namespace Tests\Feature;

use App\UseCases\CoverImage\DeleteCoverImageUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class DeleteBookPageTest extends TestCase
{
    use RefreshDatabase;

    private bool $seed = true;

    public function test_can_delete_book()
    {
        $spy = $this->spy(DeleteCoverImageUseCase::class);
        $spy->shouldReceive('run')
            ->andReturn(true);

        $response = $this->followingRedirects()->delete('/1');

        $response->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Index')
                    ->where('flash.message', 'Book deleted!')
            );

        $this->assertDeleted('books', [
            'id' => 1
        ]);
    }

    public function test_should_get_error_for_invalid_book()
    {
        $response = $this->followingRedirects()->delete('/100');

        $response->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Index')
                    ->has('flash.error')
            );
    }

    public function test_should_get_error_if_cover_image_can_not_be_deleted()
    {
        $spy = $this->spy(DeleteCoverImageUseCase::class);
        $spy->shouldReceive('run')
            ->andReturn(false);

        $response = $this->followingRedirects()->delete('/1');

        $response->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Index')
                    ->has('flash.error')
            );
    }
}
