<?php

declare(strict_types=1);

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\PageController as BackendPageController;
use App\Http\Controllers\Backend\PhotoController as BackendPhotoController;
use App\Http\Controllers\Backend\PostCollectionController as BackendPostCollectionController;
use App\Http\Controllers\Backend\PostController as BackendPostController;
use App\Http\Controllers\Backend\PostTypeController as BackendPostTypeController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostCollectionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Photo routes
Route::controller(PhotoController::class)->group(function (): void {
    Route::get('/photos', 'index')->name('photos');
    Route::get('/photos/{year}', 'year')->name('photos.year');
    Route::get('/photos/{year}/{month}', 'month')->name('photos.month');
    Route::get('/photos/{year}/{month}/{slug}', 'show')->name('photos.show');
});

// Post routes
Route::controller(PostController::class)->group(function (): void {
    Route::get('/posts', 'index')->name('posts');
    Route::get('/stream', 'stream')->name('posts.stream');
    Route::post('/posts/comment', 'submit')->name('posts.comment');
    Route::get('/posts/type', 'types')->name('posts.types');
    Route::get('/posts/type/{type}', 'type')->name('posts.type');
    Route::get('/posts/{year}', 'year')->name('posts.year');
    Route::get('/posts/{year}/{month}', 'month')->name('posts.month');
    Route::get('/posts/{year}/{month}/{slug}', 'show')->name('posts.show');
});

// Post search routes
Route::controller(SearchController::class)->group(function (): void {
    Route::get('/search', 'index')->name('search.search');
});

Route::controller(PostCollectionController::class)->group(function (): void {
    Route::get('/collections', 'index')->name('collections');
    Route::get('/collections/{collection}', 'show')->name('collections.collection');
});

// Feed routes
Route::controller(FeedController::class)->group(function (): void {
    Route::get('/feed/posts.xml', 'posts')->name('feeds.posts');
    Route::get('/feed/photos.xml', 'photos')->name('feeds.photos');
    Route::get('/feed/stream.xml', 'stream')->name('feeds.stream');
});

Route::redirect('/feed', '/feed/posts.xml');

// Sitemap routes
Route::controller(SitemapController::class)->group(function (): void {
    Route::get('/sitemap.xml', 'index')->name('sitemap');
    Route::get('/sitemap_posts.xml', 'posts')->name('sitemap.posts');
    Route::get('/sitemap_photos.xml', 'photos')->name('sitemap.photos');
    Route::get('/sitemap_pages.xml', 'pages')->name('sitemap.pages');
});

// Backend routes
Route::get('/backend/backend.webmanifest', [BackendController::class, 'webmanifest'])->name('backend.webmanifest');

Route::middleware(['auth', 'verified'])->prefix('backend')->name('backend.')->group(function (): void {
    Route::get('/', [BackendController::class, 'index'])->name('index');

    Route::controller(BackendController::class)->group(function (): void {
        Route::get('/users', 'users')->name('users.index');
        Route::get('/users/create', 'createUser')->name('users.create');
        Route::post('/users', 'storeUser')->name('users.store');
        Route::get('/users/{user}', 'showUser')->name('users.show');
        Route::get('/users/{user}/edit', 'editUser')->name('users.edit');
        Route::put('/users/{user}', 'updateUser')->name('users.update');
        Route::delete('/users/{user}', 'destroyUser')->name('users.destroy');
    });

    Route::apiResource('pages', BackendPageController::class);
    Route::resource('photos', BackendPhotoController::class);
    Route::resource('posts', BackendPostController::class);
    Route::apiResource('collections', BackendPostCollectionController::class);
    Route::apiResource('types', BackendPostTypeController::class);
});

// Page routes
Route::controller(PageController::class)->group(function (): void {
    Route::get('/', 'home')->name('home');
    Route::get('/site.webmanifest', 'webmanifest')->name('webmanifest');
    Route::get('/robots.txt', 'robots')->name('robots');
    Route::get('/{slug}', 'show')->name('page.show');
});
