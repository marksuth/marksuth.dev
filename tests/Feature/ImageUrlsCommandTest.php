<?php

declare(strict_types=1);

use App\Models\Post;
use Illuminate\Support\Facades\Artisan;

it('removes photos/ and films/ prefix from img_url in meta', function () {
    $post1 = Post::factory()->create([
        'meta' => ['img_url' => 'photos/image1.jpg', 'other' => 'value'],
    ]);

    $post2 = Post::factory()->create([
        'meta' => ['img_url' => 'films/image2.png'],
    ]);

    $post3 = Post::factory()->create([
        'meta' => ['img_url' => 'no-prefix.jpg'],
    ]);

    Artisan::call('photo:filenames');

    expect($post1->fresh()->meta['img_url'])->toBe('image1.jpg')
        ->and($post1->fresh()->meta['other'])->toBe('value')
        ->and($post2->fresh()->meta['img_url'])->toBe('image2.png')
        ->and($post3->fresh()->meta['img_url'])->toBe('no-prefix.jpg');
});
