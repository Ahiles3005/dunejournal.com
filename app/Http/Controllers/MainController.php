<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\News;
use App\Models\NewsTags;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    private News $news;
    private NewsTags $newsTags;

    public function __construct(Request $request, News $news, NewsTags $newsTags){
        parent::__construct($request);
        $this->news = $news;
        $this->newsTags = $newsTags;
    }

    public function index(){
        return view('index', [
            'tags' => Tags::orderBy('id', 'desc')->get(),
            'categories' => Categories::all(),
            'news' => $this->news->getSorted()
        ]);
    }

    public function personal(){
        return view('personal', [
            'tags' => Tags::orderBy('id', 'desc')->get(),
            'categories' => Categories::all(),
        ]);
    }

    public function about(){
        return view('about', [
            'tags' => Tags::orderBy('id', 'desc')->get(),
            'categories' => Categories::all(),
        ]);
    }

    public function search(){
        $validator = Validator::make($this->request->all(), [
            'value' => ['required', 'string', 'min:1'],
        ]);

        if( $validator->fails() ) return jsonResponse( ['error' => concatErrors( $validator->errors()->getMessages() ) ] );

        $value = strtolower($this->request->value);

        return jsonResponse( view('ajax_news', [
            'news' => $this->news->search($value)
        ])->render() );
    }

    public function filterByTag(){
        if( !isset($this->request->id) ) return redirect()->back()->withErrors('Не удалось обнаружить тэг для поиска!');

        $id = intval($this->request->id);

        $tag = Tags::find($id);
        if($tag == null) return redirect()->back()->withErrors('Не удалось обнаружить тэг для поиска!');

        return view('tag_news', [
            'tags' => Tags::orderBy('id', 'desc')->get(),
            'categories' => Categories::all(),
            //'news' => $this->newsTags->findNews($this->news, $id),
            'news' => $this->news->filterByTag($id),
            'title' => $tag->name
        ]);
    }

    public function filterByCategory(){
        if( !isset($this->request->id) ) return redirect()->back()->withErrors('Не удалось обнаружить категорию для поиска!');

        $id = intval($this->request->id);

        $category = Categories::find($id);
        if($category == null) return redirect()->back()->withErrors('Не удалось обнаружить категорию для поиска!');

        return view('category_news', [
            'tags' => Tags::orderBy('id', 'desc')->get(),
            'categories' => Categories::all(),
            'news' => $this->news->filterByCategory($id),
            'title' => $category->name
        ]);
    }

    public function pageNews(){
        if( !isset($this->request->id) ) return redirect()->back()->withErrors('Не передано параметр для поиск новостей!');

        $id = intval($this->request->id);

        $article = News::find($id);
        if($article == null) return redirect()->back()->withErrors('Не удалось обнаружить найти новость!');

        $randomTag = Tags::inRandomOrder()->first();

        return view('full_news', [
            'tags' => Tags::orderBy('id', 'desc')->get(),
            'categories' => Categories::all(),
            'article' => $article,
            'random_tag_article' => $this->news->articleByTag($randomTag),  // FIX IT
            'random_articles' => $this->news->getRandom(3, 'standart')
        ]);
    }
}
