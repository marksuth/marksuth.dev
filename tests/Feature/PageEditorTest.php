<?php

declare(strict_types=1);

use App\Livewire\PageEditor;
use App\Models\Page;
use Livewire\Livewire;

it('can render the page editor', function () {
    Livewire::test(PageEditor::class)
        ->assertStatus(200);
});

it('can mount the page editor with a page', function () {
    $page = Page::factory()->create();

    Livewire::test(PageEditor::class, ['page' => $page])
        ->assertStatus(200)
        ->assertSet('title', $page->title);
});

it('can save a new page', function () {
    Livewire::test(PageEditor::class)
        ->set('title', 'Test Page')
        ->set('slug', 'test-page')
        ->set('content', 'Test content')
        ->call('save');

    $this->assertDatabaseHas('pages', [
        'title' => 'Test Page',
        'slug' => 'test-page',
    ]);
});
