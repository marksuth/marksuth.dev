<?php

use App\Http\Controllers\Backend\BackendCollectionController;
use App\Http\Controllers\Backend\BackendDashboardController;
use App\Http\Controllers\Backend\BackendNoteController;
use App\Http\Controllers\Backend\BackendPageController;
use App\Http\Controllers\Backend\BackendPhotoController;
use App\Http\Controllers\Backend\BackendPostController;
use App\Http\Controllers\Backend\BackendTypeController;
use App\Http\Controllers\Backend\BackendUserController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostCollectionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Photo routes
Route::controller(PhotoController::class)->group(function () {
    Route::get('/photos', 'index')->name('photos');
    Route::get('/photos/{year}', 'year')->name('photos.year');
    Route::get('/photos/{year}/{month}', 'month')->name('photos.month');
    Route::get('/photos/{year}/{month}/{slug}', 'show')->name('photos.show');
});

// Post routes
Route::controller(PostController::class)->group(function () {
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
Route::controller(SearchController::class)->group(function () {
    Route::get('/search', 'index')->name('search.search');
});

Route::controller(PostCollectionController::class)->group(function () {
    Route::get('/collections', 'index')->name('collections');
    Route::get('/collections/{collection}', 'show')->name('collections.collection');
});

// Feed routes
Route::controller(FeedController::class)->group(function () {
    Route::get('/feed/posts.xml', 'posts')->name('feeds.posts');
    Route::get('/feed/photos.xml', 'photos')->name('feeds.photos');
    Route::get('/feed/stream.xml', 'stream')->name('feeds.stream');
});

Route::redirect('/feed', '/feed/posts.xml');

// Sitemap routes
Route::controller(SitemapController::class)->group(function () {
    Route::get('/sitemap.xml', 'index')->name('sitemap');
    Route::get('/sitemap_posts.xml', 'posts')->name('sitemap.posts');
    Route::get('/sitemap_photos.xml', 'photos')->name('sitemap.photos');
    Route::get('/sitemap_pages.xml', 'pages')->name('sitemap.pages');
});

// Backend routes
Route::controller(BackendDashboardController::class)->group(function () {
    Route::get('/backend', 'index')->middleware('auth')->name('backend.index');
    Route::get('/backend.webmanifest', 'webmanifest')->name('backend.webmanifest');
});

Route::controller(BackendPageController::class)->middleware(['auth'])->group(function () {
    Route::get('/backend/pages', 'index')->name('backend.pages');
    Route::get('/backend/pages/create', 'create')->name('backend.pages.create');
    Route::post('/backend/pages/create', 'store')->name('backend.pages.store');
    Route::get('/backend/pages/{id}', 'show')->name('backend.pages.show');
    Route::get('/backend/pages/{id}/edit', 'edit')->name('backend.pages.edit');
    Route::put('/backend/pages/{id}', 'update')->name('backend.pages.update');
    Route::get('/backend/pages/{id}/delete', 'destroy')->name('backend.pages.destroy');
});

Route::controller(BackendPostController::class)->middleware(['auth'])->group(function () {
    Route::get('/backend/posts', 'index')->name('backend.posts');
    Route::get('/backend/posts/create', 'create')->name('backend.posts.create');
    Route::post('/backend/posts/create', 'store')->name('backend.posts.store');
    Route::get('/backend/posts/{id}', 'show')->name('backend.posts.show');
    Route::get('/backend/posts/{id}/edit', 'edit')->name('backend.posts.edit');
    Route::put('/backend/posts/{id}', 'update')->name('backend.posts.update');
    Route::get('/backend/posts/{id}/delete', 'destroy')->name('backend.posts.destroy');
});

Route::controller(BackendNoteController::class)->middleware(['auth'])->group(function () {
    Route::get('/backend/notes', 'index')->name('backend.notes');
    Route::get('/backend/notes/create', 'create')->name('backend.notes.create');
    Route::post('/backend/notes/create', 'store')->name('backend.notes.store');
    Route::get('/backend/notes/{id}', 'show')->name('backend.notes.show');
    Route::get('/backend/notes/{id}/edit', 'edit')->name('backend.notes.edit');
    Route::put('/backend/notes/{id}', 'update')->name('backend.notes.update');
    Route::get('/backend/notes/{id}/delete', 'destroy')->name('backend.notes.destroy');
});

Route::controller(BackendPhotoController::class)->middleware(['auth'])->group(function () {
    Route::get('/backend/photos', 'index')->name('backend.photos');
    Route::get('/backend/photos/create', 'create')->name('backend.photos.create');
    Route::post('/backend/photos/create', 'store')->name('backend.photos.store');
    Route::get('/backend/photos/{id}', 'show')->name('backend.photos.show');
    Route::get('/backend/photos/{id}/edit', 'edit')->name('backend.photos.edit');
    Route::put('/backend/photos/{id}', 'update')->name('backend.photos.update');
    Route::get('/backend/photos/{id}/delete', 'destroy')->name('backend.photos.destroy');
});

Route::controller(BackendCollectionController::class)->middleware(['auth'])->group(function () {
    Route::get('/backend/collections', 'index')->name('backend.collections');
    Route::get('/backend/collections/create', 'create')->name('backend.collections.create');
    Route::post('/backend/collections/create', 'store')->name('backend.collections.store');
    Route::get('/backend/collections/{id}', 'show')->name('backend.collections.show');
    Route::get('/backend/collections/{id}/edit', 'edit')->name('backend.collections.edit');
    Route::put('/backend/collections/{id}', 'update')->name('backend.collections.update');
    Route::get('/backend/collections/{id}/delete', 'destroy')->name('backend.collections.destroy');
});

Route::controller(BackendTypeController::class)->middleware(['auth'])->group(function () {
    Route::get('/backend/types', 'index')->name('backend.types');
    Route::get('/backend/types/create', 'create')->name('backend.types.create');
    Route::post('/backend/types/create', 'store')->name('backend.types.store');
    Route::get('/backend/types/{id}', 'show')->name('backend.types.show');
    Route::get('/backend/types/{id}/edit', 'edit')->name('backend.types.edit');
    Route::put('/backend/types/{id}', 'update')->name('backend.types.update');
    Route::get('/backend/types/{id}/delete', 'destroy')->name('backend.types.destroy');
});

Route::controller(BackendUserController::class)->middleware(['auth'])->group(function () {
    Route::get('/backend/users', 'index')->name('backend.users');
    Route::get('/backend/users/create', 'create')->name('backend.users.create');
    Route::post('/backend/users/create', 'store')->name('backend.users.store');
    Route::get('/backend/users/{id}', 'show')->name('backend.users.show');
    Route::get('/backend/users/{id}/edit', 'edit')->name('backend.users.edit');
    Route::put('/backend/users/{id}', 'update')->name('backend.users.update');
    Route::get('/backend/users/{id}/delete', 'destroy')->name('backend.users.destroy');
});

// Page routes
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/site.webmanifest', 'webmanifest')->name('webmanifest');
    Route::get('/robots.txt', 'robots')->name('robots');
    Route::get('/{slug}', 'show')->name('page.show');
});
