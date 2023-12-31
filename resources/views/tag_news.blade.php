@extends('components.wrapper')

@section('title', $seoTitle)
@section('description', $seoDescription)

@section('arabic-text')
    <img src="{{ asset("assets/images/top-text.png") }}" alt="" class="img-adaptive head-arabic">
@endsection

@section('content')
    <main class="content-limited">
        @if ( count($news) < 1 )
            <p class="no-items">Не удалось обнаружить новости по текущему тэгу!</p>
        @else

            @foreach ($news as $key => $value)

                {{-- Standart news 1x2 row --}}
                @if (is_array($value))
                    <div class="news-row">
                        @foreach ($value as $item)
                            <div class="news" onclick="window.open('{{ route('page.news', ['slug' => $item->slug]) }}', '_self')">
                                @if ($item->asset_url == null)
                                    <img loading="lazy" src="{{ asset('assets/images/news_example.png') }}" alt="" class="img-adaptive news__image">
                                @else
                                    <img loading="lazy" src="{{ $item->asset_url }}" alt="" class="img-adaptive news__image">
                                @endif

                                <div class="news-filter">{{ $item->tag_name }}</div>
                                <div class="news__shadow"></div>

                                <div class="news__short">
                                    <span class="news__date">{{ formatHumanDate($item->created_at) }}</span>
                                    <p class="news__text"><a href="{{ route('page.news', ['slug' => $item->slug]) }}">{{ $item->short_descr }}</a></p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                {{-- Hot news 1x1 row --}}
                @else

                    @if ($value->asset_url == null)
                        <div class="news-big" onclick="window.open('{{ route('page.news', ['slug' => $value->slug]) }}', '_self')">
                            <img src="{{ asset("assets/images/banner-text.png") }}" alt="" class="banner-arabic">
                           <p class="news-big__text"> <a href="{{ route('page.news', ['slug' => $value->slug]) }}">{{ $value->short_descr }}</a></p>
                            <div class="news-filter">{{ $value->tag_name }}</div>
                        </div>
                    @else
                        <div class="news-video" onclick="window.open('{{ route('page.news', ['slug' => $value->slug]) }}', '_self')">
                            <img class="background img-adaptive" src="{{ asset("assets/images/mid-text.png") }}" alt=""/>

                            <div class="video">
                                @if ( isVideo($value->asset_url) )
                                    <video width="198" height="345" controls>
                                        <source src="{{ $value->asset_url }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <img src="{{ $value->asset_url }}" alt="" class="img-adaptive hot-image">
                                    <!-- <button class="btn video__play"></button> -->
                                @endif

                            </div>

                            <div class="news-video__short">
                                <span class="news-video__date">{{ formatHumanDate($value->created_at) }}</span>
                                <p class="news-video__text"><a href="{{ route('page.news', ['slug' => $value->slug]) }}">{{ $value->short_descr }}</a></p>
                            </div>

                            <div class="news-filter">{{ $value->tag_name }}</div>
                        </div>
                    @endif

                @endif

            @endforeach
        @endif
    </main>
@endsection
