<rss xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:turbo="http://turbo.yandex.ru" version="2.0">
    <channel>
        <title>Dubai News - Ваш источник новостей, событий и развлечений в Дубае</title>
        <link>
        https://dunejournal.com</link>
        <language>ru</language>
        <author>https://dunejournal.com</author>
        <description>Добро пожаловать на Dubai News! Мы предлагаем вам самую актуальную информацию о событиях, новостях,
            местах отдыха, кафе и ресторанах Дубая. Оставайтесь в курсе всего, что происходит в этом удивительном
            городе.
        </description>
        <yandex:analytics type="Yandex" id="92970081"/>
{{--        <yandex:related>--}}
{{--            @foreach( $tags as $tag )--}}
{{--                <link url="{{ url('list/tag', $tag->slug) }}">{{ $tag->name }}</link>--}}
{{--            @endforeach--}}
{{--            @foreach( $categories as $category )--}}
{{--                <link url="{{ url('list/category', $category->slug) }}">{{ $category->name }}</link>--}}
{{--            @endforeach--}}
{{--        </yandex:related>--}}
        @foreach( $news as $new )
            <item turbo="true">
                <link>{{ url('article', $new->slug) }}</link>
                <category>{{ $new->tags->first()->name ?? '' }}</category>
                <pubDate>{{ \Carbon\Carbon::parse( $new->created_at )->format( 'D, d M Y H:i:s O' ) }}</pubDate>
                <turbo:content>
                    <![CDATA[
                    <header>
                        <h1>{{ $new->short_descr }}</h1>
                        <figure>
                            <img src="{{$new->full_image }}">
                        </figure>
                        <menu>
                            @foreach( $news as $new2 )
                                <a href="{{ url('article', $new2->slug) }}">{{ $new2->short_descr }}</a>
                            @endforeach
                        </menu>
                    </header>
                    {!! $new->full_descr !!}
                    ]]>
                </turbo:content>
            </item>
        @endforeach
    </channel>
</rss>
