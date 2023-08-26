<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MTFC8RGEJE"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-MTFC8RGEJE');
    </script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
    
        ym(92970081, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/92970081" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@yield('description', 'Новостной портал Dubai')">
    <meta name="keywords" content="Dubai, news, новости Дубай, Дубай">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <title>@yield('title', 'Dubai News')</title>

    <link rel="stylesheet" href="{{ mix('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/quick.css') }}?v=1">
</head>
<body>

    @yield('arabic-text')

    {{-- HEADER  --}}
    <div class="header">
        <h1 class="header__logo"><a href="/">DUNE</a></h1>

        <nav class="header__nav">
            <ul class="inline-ul pc-nav">
                @foreach ($categories as $item)
                    <li><a href="/list/category/{{ $item->id }}">{{$item->name}}</a></li>
                @endforeach
            </ul>

            <div class="mob-nav">
                <button class="btn burger"></button>

                <div class="mob-nav__content" style="display: none">
                    <ul class="inline-ul">
                        @foreach ($categories as $item)
                            <li><a href="/list/category/{{ $item->id }}">{{$item->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>

        <div class="widget">
            <span class="weather"><span id="temperature">..</span>&deg;C</span>
            <span class="time"><span id="calendar">..</span></span>
        </div>
    </div>

    {{-- LEFTBAR FILTERS --}}
    <aside class="leftbar">
        <div class="tags-list" style="display: none">
            @foreach ($tags as $item)
                <a href="/list/tag/{{ $item->id }}"><button class="btn tag" data-hover_color="{{$item->hover_color}}" data-id="{{ $item->id }}">{{$item->name}}</button></a>
            @endforeach
        </div>

        <div class="tag-selected closed" data-id="">
            <span>Выберите тэг..</span>
            <img src="{{ asset("assets/images/tag-arrow.svg") }}" alt="" class="tag-arrow">
        </div>
    </aside>

    {{-- MAIN --}}
    @yield('content')

    <footer class="footer">

        <div class="toolbar-content" style="display: none">
            <div class="toolbar-content__header">
                <span class="toolbar-logo"><a href="#">DUNE</a></span>
                <div class="search">
                    @csrf
                    <input type="text" name="value" id="search-value" placeholder="Поиск по сайту" class="input-clear">
                    <img src="{{ asset("assets/images/icon-search_toolbar.svg") }}" alt="" id="search-send">
                </div>
                <img src="{{ asset("assets/images/icon-minimize.svg") }}" alt="" class="minimize">
            </div>

            <div class="toolbar-content__body">
                <div class="toolbar-content__left">
                    <p class="toolbar-content__label">Главное:</p>
                    <div class="toolbar-content__items">
                        <ul class="ul-clear">
                            @foreach ($tags->where('is_hot', 1) as $item)
                                <li><a href="/list/tag/{{ $item->id }}" class="tag-anchor" data-id="{{ $item->id }}">{{$item->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="toolbar-content__right">
                    <p class="toolbar-content__label">Тэги:</p>
                    <div class="toolbar-content__items">
                        <ul class="inline-ul">
                            @foreach ($tags as $item)
                                <li><a href="/list/tag/{{ $item->id }}" class="tag-anchor" data-id="{{ $item->id }}">{{$item->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="toolbar-content__footer">
                <ul class="inline-ul">
                    <li><a href="https://t.me/vefont">Заказать рекламу</a></li>
                    <li><a href="{{ route('page.about') }}">О проекте</a></li>
                    <li><a href="https://t.me/dubaimapbot">Прислать новость</a></li>
                    {{-- <li><a href="{{ route('page.personal') }}">Пользовательское соглашение</a></li> --}}
                </ul>

                <div class="toolbar-content__footer-buttons">
                    <a href="https://www.instagram.com/dubai_headline">
                        <button class="btn btn-toolbar-link"><img src="{{ asset("assets/images/icon-instagram.svg") }}" alt=""></button>
                    </a>

                    <a href="https://t.me/dubaimap">
                        <button class="btn btn-toolbar-link"><img src="{{ asset("assets/images/icon-telegram.svg") }}" alt=""></button>
                    </a>
                </div>
            </div>

        </div>

        <div class="toolbar">
            <span class="toolbar-logo"><a href="#">DUNE</a></span>

            <div class="toolbar__hot-items">
                <ul class="inline-ul">
                    @foreach ($tags->where('is_hot', 1) as $item)
                        <li><a href="/list/tag/{{ $item->id }}">{{$item->name}}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="toolbar__buttons hidden">
                <button class="btn btn-toolbar btn-search"><img src="{{ asset("assets/images/icon-search.svg") }}" alt=""></button>
                <button class="btn btn-toolbar"><img src="{{ asset("assets/images/icon-more.svg") }}" alt=""></button>
            </div>
        </div>
    </footer>

    <div class="alert" style="display: none">
        <span></span>
    </div>

    <script src="{{ mix('assets/js/app.js') }}"></script>

    @if ( $errors->any() )
        <script>
            showMessage('error', JSON.parse(@json( $errors->toJson(), JSON_UNESCAPED_UNICODE)).error);
        </script>
    @endif

    @if( session('success') )
        <script>
            showMessage('success', @json( session('success'), JSON_UNESCAPED_UNICODE) );
        </script>
    @endif


    @yield('extra_js')
</body>
</html>
