<?php

use App\Models\Note;

test('note model can be instantiated', function (): void {
    $note = new Note;
    expect($note)->toBeInstanceOf(Note::class);
});

test('note model has correct casts', function (): void {
    $note = new Note;
    expect($note->getCasts())
        ->toHaveKey('meta', 'array');
});
