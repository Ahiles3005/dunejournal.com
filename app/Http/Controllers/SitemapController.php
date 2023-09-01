<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\News;
use App\Models\Tags;
use DateTime;
class SitemapController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->first();

        return response()->view('sitemap.index', [
            'news' => (new \DateTime($news->created_at))->format(DateTime::ATOM),
            'category' => (new \DateTime())->format(DateTime::ATOM),
            'tag' => (new \DateTime())->format(DateTime::ATOM),
        ])->header('Content-Type', 'text/xml');
    }

    public function news()
    {
        $news = News::orderBy('created_at', 'desc')->get();
        return response()->view('sitemap.news', [
            'news' => $news,
        ])->header('Content-Type', 'text/xml');
    }

    public function categories()
    {
        $categories = Categories::all();
        return response()->view('sitemap.categories', [
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }

    public function tags()
    {
        $tags = Tags::all();
        return response()->view('sitemap.tags', [
            'tags' => $tags,
        ])->header('Content-Type', 'text/xml');
    }
}
