<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class IndexBookPageTest extends TestCase
{
    use RefreshDatabase;

    private bool $seed = true;

    public function test_can_view_books()
    {
        $response = $this->get('/');

        $response
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) =>
                 $page->component('Books/Index')
                    ->has('books', 12, fn (Assert $page) =>
                        $page->hasAll('id', 'title', 'author', 'description', 'image')
                            ->etc()
                    )
                    ->where('meta.current_page', 1)
            );
    }

    public function test_can_paginate_books() {
        $response = $this->get('/?page=2');

        $response
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) =>
            $page->component('Books/Index')
                ->has('books', 12, fn (Assert $page) =>
                $page->hasAll('id', 'title', 'author', 'description', 'image')
                    ->etc()
                )
                ->where('meta.current_page', 2)
            );
    }

    public function test_can_query_books_by_title() {
        $book = Book::first();
        list($title) = explode(' ', $book->title);

        $response = $this->get("/?query=$title");

        $response
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Books/Index')
                    ->has('books')
            );
    }

    public function test_can_query_books_by_author() {
        $book = Book::first();
        list($author) = explode(' ', $book->author);

        $response = $this->get("/?query=$author");

        $response
            ->assertStatus(200)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Books/Index')
                    ->has('books')
            );
    }
}
