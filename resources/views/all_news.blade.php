@extends('components.wrapper')

@section('title', $seoTitle)
@section('description', $seoDescription)

@section('arabic-text')
    <img src="{{ asset("assets/images/top-text.png") }}" alt="" class="img-adaptive head-arabic">
@endsection

@section('content')
    <main class="content-limited">
        @if ( count($news) < 1 )
            <p class="no-items">Не удалось обнаружить новости по текущей категории!</p>
        @else

            @foreach ($news as $key => $value)
                    <div class="news-row">
                        @foreach ($value as $item)
                            <div class="news" onclick="window.open('{{ route('page.news', ['slug' => $item->slug]) }}', '_self')">
                                @if ($item->asset_url == null || isVideo($item->asset_url))
                                    <img loading="lazy" src="{{ asset('assets/images/news_example.png') }}" alt="" class="img-adaptive news__image">
                                @else
                                    <img loading="lazy" src="{{ $item->asset_url }}" alt="" class="img-adaptive news__image">
                                @endif

                                <div class="news-filter">{{ $item->tags->first()->name }}</div>
                                <div class="news__shadow"></div>

                                <div class="news__short">
                                    <span class="news__date">{{ formatHumanDate($item->created_at) }}</span>
                                    <p class="news__text"><a href="{{ route('page.news', ['slug' => $item->slug]) }}">{{ $item->short_descr }}</a></p>
                                </div>
                            </div>
                        @endforeach
                    </div>




            @endforeach
        @endif
    </main>
@endsection
