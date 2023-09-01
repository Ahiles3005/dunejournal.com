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

    public function filterByTag()
    {
        if (!isset($this->request->slug)) {
            return redirect()->back()->withErrors('Не удалось обнаружить тэг для поиска!');
        }

        $slug = $this->request->slug;
        $tag = Tags::where('slug', $slug)->first();

        if ($tag == null) {
            $tag = Tags::find($slug);
            if($tag !== null){
                return redirect()->secure("/list/tag/{$tag->slug}", 301);
            }
            return redirect()->back()->withErrors('Не удалось обнаружить тэг для поиска!');
        }

        return view('tag_news', [
            'tags' => Tags::orderBy('id', 'desc')->get(),
            'categories' => Categories::all(),
            //'news' => $this->newsTags->findNews($this->news, $id),
            'news' => $this->news->filterByTag($tag->id),
            'title' => $tag->name,
            'seoTitle' => "{$tag->name}: Интересные новости, мероприятия и развлечения в Дубае | Dubai News",
            'seoDescription' => "{$tag->name} в Дубае на Dubai News. Новости, интересные события и места ожидают вас. Будьте в курсе вместе с нами!"
        ]);
    }

    public function filterByCategory()
    {
        if (!isset($this->request->slug)) {
            return redirect()->back()->withErrors('Не удалось обнаружить категорию для поиска!');
        }

        $slug = $this->request->slug;
        $category = Categories::where('slug', $slug)->first();
        if ($category == null) {
            $category = Categories::find($slug);
            if($category !== null){
                return redirect()->secure("/list/category/{$category->slug}", 301);
            }
            return redirect()->back()->withErrors('Не удалось обнаружить категорию для поиска!');
        }

        $id = $category->id;
        $seoTitle = null;
        $seoDescription = null;
        switch ($id) {
            case 1:
                $seoTitle = 'Лучшее в Дубае: Топовые новости, места и события | Dubai News';
                $seoDescription = 'Откройте для себя абсолютное лучшее, что предлагает Дубай! На Dubai News мы собрали для вас топовые новости, невероятные места, рестораны и события. Готовьтесь к захватывающему путешествию по самому лучшему в Дубае.';
                break;
            case 6:
                $seoTitle = 'Загляните в сердце Дубая: Городские новости, события и обзоры | Dubai News';
                $seoDescription = 'Разберитесь в пульсе Дубая с нами! На Dubai News мы предоставляем свежие новости, захватывающие события и интересные обзоры, чтобы помочь вам погрузиться в жизнь этого удивительного города.';
                break;
            case 7:
                $seoTitle = 'В центре событий: Горячие мероприятия, фестивали и встречи в Дубае | Dubai News';
                $seoDescription = ' Будьте в курсе самых ярких и захватывающих мероприятий в Дубае! На Dubai News мы следим за горячими событиями, праздниками и встречами, чтобы вы не упустили ни одной возможности порадоваться уникальным событиям города.';
                break;
            case 9:
                $seoTitle = 'Путеводитель по развлечениям: Куда сходить в Дубае для незабываемого времяпрепровождения | Dubai News';
                $seoDescription = 'Путешествие в мир развлечений! На Dubai News мы подготовили для вас самый полный путеводитель по тому, куда стоит отправиться в Дубае для незабываемого и интересного отдыха.';
                break;
            case 10:
                $seoTitle = 'Волшебный мир детства: Подборка лучших мероприятий и развлечений для детей в Дубае | Dubai News';
                $seoDescription = 'Откройте для ваших маленьких приключенцев дверь в волшебный мир! На Dubai News мы собрали для вас самые интересные мероприятия, места и развлечения, чтобы сделать времяпровождение в Дубае незабываемым для детей.';
                break;
            case 13:
                $seoTitle = 'Кулинарное путешествие: Откройте для себя лучшие кафе и рестораны Дубая | Dubai News';
                $seoDescription = 'Погрузитесь в мир гастрономических наслаждений! На Dubai News мы представляем вам подборку лучших кафе и ресторанов, где вы сможете насладиться великолепными блюдами и атмосферой Дубая.';
                break;
            case 14:
                $seoTitle = 'Дубай без затрат: Лучшие бесплатные мероприятия и развлечения в городе | Dubai News';
                $seoDescription = 'Откройте для себя множество возможностей для бесплатного отдыха в Дубае! На Dubai News мы собрали для вас самые интересные бесплатные мероприятия, места и развлечения, чтобы позволить вам насладиться городом без дополнительных затрат.';
                break;
        }

        return view('category_news', [
            'tags' => Tags::orderBy('id', 'desc')->get(),
            'categories' => Categories::all(),
            'news' => $this->news->filterByCategory($id),
            'title' => $category->name,
            'seoTitle' => $seoTitle ?? $category->name,
            'seoDescription' => $seoDescription ?? $category->name
        ]);
    }

    public function pageNews()
    {
        if (!isset($this->request->slug)) {
            return redirect()->back()->withErrors('Не передано параметр для поиск новостей!');
        }

        $slug = $this->request->slug;

        $article = News::where('slug', $slug)->first();

        if ($article == null) {
            $article = News::find($slug);
            if($article !== null){
                return redirect()->secure("/article/{$article->slug}", 301);
            }
            return redirect()->back()->withErrors('Не удалось обнаружить найти новость!');
        }

        $randomTag = Tags::inRandomOrder()->first();

        return view('full_news', [
            'tags' => Tags::orderBy('id', 'desc')->get(),
            'categories' => Categories::all(),
            'article' => $article,
            'random_tag_article' => $this->news->articleByTag($randomTag),  // FIX IT
            'random_articles' => $this->news->getRandom(3, 'standart'),
            'seoTitle' => "{$article->short_descr} | Dubai News",
            'seoDescription' => "{$article->short_descr} узнайте больше о в статье на Dubai News. Мы предоставляем интересные подробности, анализ и информацию о событиях и местах Дубая."
        ]);
    }

    public function pageAllNews()
    {
        return view('all_news', [
            'tags' => Tags::orderBy('id', 'desc')->get(),
            'categories' => Categories::all(),
            'news' => News::all()->sortDesc()->chunk(2),
            'title' => 'Все новости',
            'seoTitle' => 'Все новости | Dubai News',
            'seoDescription' => 'Все новости узнайте больше о в статье на Dubai News. Мы предоставляем интересные подробности, анализ и информацию о событиях и местах Дубая.'

        ]);
    }

    public function yandexTurboRss()
    {
        return response()->view('yandex_turbo',
            [
//            'tags' => Tags::all()->sortDesc(),
//            'categories' => Categories::all(),
            'news' => News::all()->sortDesc(),
            ]
        )->header('Content-Type', 'text/xml');
    }



}
