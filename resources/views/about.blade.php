@extends('components.wrapper')

@section('title', "Dubai News | О портале")

@section('arabic-text')
    <img src="{{ asset("assets/images/left-text.png") }}" alt="" class="img-adaptive head-arabic" style="position:fixed; min-height: 100%; width: auto; left: auto;">
@endsection

@section('content')
    <main class="content-limited info">

        <h1 class="big-header">Новостной канал о жизни в Дубае</h1>

        <p class="label">Мы создали этот проект для людей, и ради людей. Каждый день мы стараемся находить интересные новости, события, красивые места. Мы всегда открыты к идеям сотрудничества и дружбе</p>

        <div class="cooperation">
            <div class="flex-row">
                <div class="discuss discuss_green" onclick="window.open('https://t.me/vefont', '_self')">
                    <a href="#">По вопросам рекламы</a>
                </div>

                <div class="discuss discuss_blue" onclick="window.open('https://t.me/here4', '_self')">
                    <a href="#">Обсуждение проектов или интеграции</a>
                </div>
            </div>

            <div class="flex-row">
                <div class="discuss discuss_full discuss_purple" onclick="window.open('https://t.me/dubaimapbot', '_self')">
                    <a href="#">Увидели что-то интересное и хотите поделиться, скидывайте фото и видео в бота </a>
                </div>
            </div>
        </div>

        <div class="chats">
            <p>
                <a href="https://t.me/dubaitopic">
                    Полезные чаты Дубая в нашем телеграмм канале
                    <img src="{{ asset("assets/images/topright-arrow.svg") }}" alt="" class="img-adaptive arrow-anchor">
                </a>
            </p>
        </div>

{{--         <div class="emails">
            <div class="email">
                <p class="email__type">Реклама</p>
                <span class="email__value">sales@dune.com</span>
            </div>
            <div class="email">
                <p class="email__type">Редакция</p>
                <span class="email__value">secret@dune.com</span>
            </div>
            <div class="email">
                <p class="email__type">Поддержка</p>
                <span class="email__value">support@dune.com</span>
            </div>
            <div class="email">
                <p class="email__type">Модерация</p>
                <span class="email__value">moderation@dune.com</span>
            </div>
        </div>

        <a href="#"><button class="btn btn_white donate">Поддержать проект :)</button></a> --}}

        <h3 class="h3-custom text-center">Рассказать про нас в социальных сетях</h3>

        <div class="links">
            <a href="https://t.me/dubaitopic">
                <div class="link">
                    <img src="{{ asset("assets/images/link.svg") }}" alt="" class="img-adaptive">
                </div>
            </a>

            <a href="https://t.me/dubaitopic">
                <div class="link">
                    <img src="{{ asset("assets/images/telegram.svg") }}" alt="" class="img-adaptive">
                </div>
            </a>

            <a href="https://t.me/dubaitopic">
                <div class="link">
                    <img src="{{ asset("assets/images/vk.svg") }}" alt="" class="img-adaptive">
                </div>
            </a>
        </div>
    </main>

    {{-- Extra styles --}}
    <style>
        body {
            background: #f0f6f9;
        }
    </style>
@endsection
