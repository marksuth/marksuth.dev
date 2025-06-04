<?php

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

// Page routes
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/site.webmanifest', 'webmanifest')->name('webmanifest');
    Route::get('/robots.txt', 'robots')->name('robots');
    Route::get('/{slug}', 'show')->name('page.show');
});
