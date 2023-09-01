<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* MainController.php */
Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('page.index');    // PAGE: index
    Route::get('/personal', 'personal')->name('page.personal');    // PAGE: personal
    Route::get('/about', 'about')->name('page.about');    // PAGE: about
    Route::post('/search', 'search')->name('search');    // Search news
    Route::get('/article', 'pageAllNews')->name('page.all.news');
    //slug
    Route::get('/article/{slug}', 'pageNews')->name('page.news');    // PAGE: news
    Route::get('/list/tag/{slug}', 'filterByTag')->name('tag.search');    // Filter news by tag
    Route::get('/list/category/{slug}', 'filterByCategory')->name('category.search');    // Filter news by category
    //rss yandex turbo
    Route::get('/yandex/rss', 'yandexTurboRss')->name('yandex.turbo');    // Filter news by category
});

Route::controller(SitemapController::class)->group(function () {
    Route::get('/sitemap', 'index');
    Route::get('/sitemap/news', 'news');
    Route::get('/sitemap/categories', 'categories');
    Route::get('/sitemap/tags', 'tags');
    Route::get('/sitemap.xml', 'index');
});

/* ========================== [ADMIN] ========================== */
Route::prefix('control-panel')->group(function () {
    Route::name('admin.')->group(function () {
        /* Admin/UserController.php */
        Route::controller(UserController::class)->group(function () {
            Route::get('/', 'indexPage')->name('page.index');   // Index page
            Route::post('/auth', 'auth')->name('auth');     // Auth

            // Only if authed
            Route::middleware(['admin.authed'])->group(function () {
                Route::get('/logout', 'logout')->name('logout');   // Logout
            });
        });

        // Only if authed
        Route::middleware(['admin.authed'])->group(function () {
            /* Admin/TagsController.php */
            Route::controller(TagsController::class)->group(function () {
                Route::get('/tags', 'index')->name('page.tags');   // [Tags] Index page
                Route::post('/tag/info', 'info')->name('tag.info');   // Get info about the tag
                Route::post('/tag/edit', 'edit')->name('tag.edit');   // Edit tag
                Route::post('/tag/add', 'add')->name('tag.add');   // Add tag
                Route::post('/tag/delete', 'delete')->name('tag.del');   // Del tag
            });

            /* Admin/CategoriesController.php */
            Route::controller(CategoriesController::class)->group(function () {
                Route::get('/categories', 'index')->name('page.categories');   // [Categories] Index page
                Route::post('/category/info', 'info')->name('category.info');   // Get info about the category
                Route::post('/category/edit', 'edit')->name('category.edit');   // Edit category
                Route::post('/category/add', 'add')->name('category.add');   // Add category
                Route::post('/category/delete', 'delete')->name('category.del');   // Del category
            });

            /* Admin/NewsController.php */
            Route::controller(NewsController::class)->group(function () {
                Route::get('/news', 'index')->name('page.news');   // [News] Index page
                Route::post('/news/info', 'info')->name('news.info');   // Get info about the news
                Route::post('/news/edit', 'edit')->name('news.edit');   // Edit news
                Route::post('/news/add', 'add')->name('news.add');   // Add news
                Route::post('/news/delete', 'delete')->name('news.del');   // Del news
            });
        });
    });
});
