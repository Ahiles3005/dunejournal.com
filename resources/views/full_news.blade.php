@extends('components.wrapper')

@section('title', $seoTitle)
@section('description', $article->short_descr)

@section('arabic-text')
    <img src="{{ asset("assets/images/top-text.png") }}" alt="" class="img-adaptive head-arabic">
@endsection

@section('content')
    <style>
        .news-text a {
            color: #0d6efd;
            text-decoration: underline;
        }

        .news-text a:hover {
            color: #0b64e9;
        }
    </style>
    <main class="content-news">

        <div class="news-head">
            @if ($article->full_image != null)
                <img loading="lazy" src="{{ $article->full_image }}" alt="" class="img-adaptive news-head__image">
            @endif

            <div class="blur"></div>
            <div class="news-head__content">
                <h1 class="news-head__title">{!! $article->short_descr !!}</h1>
                {{-- <span class="news-head__label">Пустыня, шопинг-моллы, запрет на алкоголь и отсутствие налогов</span> --}}
            </div>

{{--             <div class="news-head__stats">
                <img src="{{ asset("assets/images/stats.svg") }}" alt="" class="img-adaptive stats-icon">
                <span>211K</span>
            </div> --}}

            <div class="news-filter">{{ $article->tags->first()->name ?? '' }}</div>
        </div>

        <div class="news-content">

            <div class="news-text">
{{--                 <p>В Дубай стоит приехать, чтобы увидеть самое высокое здание в мире, горнолыжный склон в торговом центре, фонтан, поющий голосом Адель, и искусственно созданный остров в виде пальмы.</p>

                <p>На один день в Дубае оказываются те, кто летит в страны Азии с длительной пересадкой. Виза в страну не нужна: на паспортном контроле ее бесплатно ставят на 30 дней.
                    Объединенные Арабские Эмираты построили на глазах всего мира: еще сорок лет назад здесь была пустыня с верблюдами. Страна состоит из эмиратов — городов, которыми управляют эмиры.
                    Столица ОАЭ — Абу-Даби, но эмират Дубай — один из самых популярных у туристов. Это город-космос, который не похож ни на один другой в мире. Именно здесь стоит красавица Бурдж-Халифа — самая высокая башня в мире, а перед ней — завораживающие поющие фонтаны, красивее которых я не видела.
                    Дубай не любит экономии: если есть время и деньги, здесь нужно обойти максимально возможное количество баров, ресторанов и лаунджей. Посетить много мест за один день не получится: это не старушка Европа, где на каждом шагу памятник архитектуры или музей. В Дубае за один день можно просто вдохнуть воздух пустыни и составить первое впечатление о городе.</p> --}}
                {!! $article->full_descr !!}
            </div>

            @if ( $article->carousel->count() > 0 )
                <div class="news-carousel">
                    @foreach ($article->carousel as $item)
                        <div class="news-carousel__item">
                            <img src="{{ $item->asset_url }}" alt="" class="img-adaptive news-carousel__image">
                        </div>
                    @endforeach

                    {{-- <div class="news-carousel__item">
                        <img src="{{ asset('assets/images/carousel_image_2.png') }}" alt="" class="img-adaptive news-carousel__image">
                    </div>
                    <div class="news-carousel__item">
                        <img src="{{ asset('assets/images/carousel_image_1.png') }}" alt="" class="img-adaptive news-carousel__image">
                    </div>
                    <div class="news-carousel__item">
                        <img src="{{ asset('assets/images/carousel_image_1.png') }}" alt="" class="img-adaptive news-carousel__image">
                    </div> --}}
                </div>
            @endif


            @if ($random_tag_article != null)
                <div class="random-article" onclick="window.open('{{ route('page.news', ['slug' => $random_tag_article->slug]) }}', '_self')">
                    <img src="{{ $random_tag_article->asset_url }}" alt="" class="img-adaptive random-article__image">

                    <span class="random-article__title"><a href="{{ route('page.news', ['slug' => $random_tag_article->slug]) }}">{!! $random_tag_article->short_descr !!}</a></span>
                </div>
            @endif



{{--             <div class="news-text">
                    {{ $article->full_descr ?? '' }}
            </div> --}}

            <div class="share">

                <p class="share__label">Поделиться материалом:</p>

                <div class="links">
                    <a href="{{ route("page.news", ['slug' => $article->slug]) }}" onclick="event.preventDefault(); copy(this)">
                        <div class="link">
                            <img src="{{ asset("assets/images/link.svg") }}" alt="" class="img-adaptive">
                        </div>
                    </a>

                    <a href="https://t.me/share/url?url={{ route("page.news", ['slug' => $article->slug]) }}&text={{ $article->short_descr }}">
                        <div class="link">
                            <img src="{{ asset("assets/images/telegram.svg") }}" alt="" class="img-adaptive">
                        </div>
                    </a>

                    <a href="http://vk.com/share.php?url={{ route("page.news", ['slug' => $article->slug]) }}&title={{ $article->short_descr }}">
                        <div class="link">
                            <img src="{{ asset("assets/images/vk.svg") }}" alt="" class="img-adaptive">
                        </div>
                    </a>
                </div>
            </div>

        </div>

    </main>

    <div class="other-news">
        <p class="read-more">Читать также</p>

        <div class="other-news__list">
            <div class="news-row">
                @foreach ($random_articles as $item)
                    <div class="news" onclick="window.open('{{ route('page.news', ['slug' => $item->slug]) }}', '_self')">
                        <img src="{{ $item->asset_url }}" alt="" class="img-adaptive news__image">

                        <div class="news-filter">{{ $item->tags->first()->name }}</div>
                        <div class="news__shadow"></div>

                        <div class="news__short">
                            <span class="news__date">{{ formatHumanDate($item->created_at) }}</span>
                            <p class="news__text"><a href="{{ route('page.news', ['slug' => $item->slug]) }}">{{ $item->short_descr }}</a></p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

    {{-- Extra styles --}}
    <style>
        body {
            background: #FFF9EE;
        }
    </style>
@endsection

@section('extra_js')
    <script>
        $(function(){
            $('.news-carousel').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                centerMode: true,
                variableWidth: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: false
                        }
                    },
                ]
            });
        });
    </script>
@endsection
