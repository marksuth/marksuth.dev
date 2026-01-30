<?php

use App\Models\Page;

test('page model can be instantiated', function (): void {
    $page = new Page;
    expect($page)->toBeInstanceOf(Page::class);
});

test('page model has correct casts', function (): void {
    $page = new Page;
    expect($page->getCasts())
        ->toHaveKey('meta', 'array')
        ->toHaveKey('published_at', 'datetime');
});
