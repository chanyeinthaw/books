<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ViewBookPageTest extends TestCase
{
    use RefreshDatabase;

    private bool $seed = true;

    public function test_can_view_book()
    {
        $response = $this->get('/1');

        $response
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Book')
                    ->where('book.id', 1)
            );
    }

    public function test_should_get_error_for_invalid_book()
    {
        $response = $this->get('/100');

        $response
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page->component('Books/Book')
                    ->where('error.code', 'Book.InvalidId')
            );
    }
}
