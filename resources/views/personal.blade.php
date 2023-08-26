@extends('components.wrapper')

@section('title', "Dubai News | Положение о персональных данных")

@section('arabic-text')
    <img src="{{ asset("assets/images/top-text_custom.png") }}" alt="" class="img-adaptive head-arabic">
@endsection

@section('content')
    <main class="content-medium info">

        <h1>Положение об обработке отдельных персональных данных</h1>

        <p class="label">Версия от [дата]</p>
        <p class="label">
            Настоящее положение об обработке отдельных персональных данных («Положение») разработано и используется в соответствии с Правилами пользования сервисом, размещенными по адресу [ссылка] («Правила») и Политикой о персональных данных ([ссылка]) («Политика»), и является их дополнением. В случае наличия противоречий между Правилами (Политикой) и Положением применению подлежат условия данного Положения. Термины, которым не присвоено иное значение настоящим Положением, используются в значении, присвоенном им Правилами или Политикой.
            <br><br>
            ООО «[Наименование]», юридическое лицо, зарегистрированное в соответствии с законодательством Российской Федерации за основным государственным регистрационным номером [ОГРН] («Администрация» или «мы») стремится к защите конфиденциальности Пользователей Сервиса, а также лиц, предоставляющих нам свои данные («Репетитор» или «вы»).
            <br><br>
            Данное Положение, размещенное по адресу [ссылка], описывает содержание согласия Репетитора на обработку Персональных данных, разрешенных Репетитором (субъектом таких персональных данных) для их распространения, в том числе неопределенному кругу лиц.
        </p>

        <p class="label label_bold">1. Общие положения.</p>
        <ul class="ul-clear">
            <li>1.1. <span>Настоящим вы даете нам свое явное согласие на обработку Персональных     данных, разрешенных субъектом персональных данных (вами) для распространения, в том числе неопределенному кругу лиц («ПД для распространения»), путем размещения на Сервисе для оказания вам услуг в соответствии с Правилами.</span></li>
        </ul>

        <p class="label label_bold">2. Перечень ПД для распространения</p>
        <ul class="ul-clear">
            <li>2.1. <span>ПД для распространения включают в себя информацию о вас, как о Репетиторе, в том числе ваши фотографии, имя, фамилию, сведения об образовании и профессиональных компетенциях.</span></li>
        </ul>

        <p class="label label_bold">3. Запреты и условия обработки ПД для распространения</p>
        <ul class="ul-clear">
            <li>3.1. <span>На ПД для распространения не установлены какие-либо запреты и особые условия их обработки.</span></li>
            <li>3.2. <span>Если вы не согласны с условием пункта 3.1 или иными условиями Положения, пожалуйста, сообщите об этом нам до предоставления своего согласия на обработку ПД для распространения.</span></li>
        </ul>

        <p class="label label_bold">4. Уведомления об изменениях</p>
        <ul class="ul-clear">
            <li>4.1. <span>Мы можем изменить данное Положение по мере изменения наших служб и практик в отношении персональных данных и конфиденциальности или в соответствии с применимыми законодательными или нормативными требованиями. В тех случаях, когда это возможно, мы уведомим вас по электронной почте о любых существенных изменениях. Тем не менее, последняя дата обновления размещена вверху страницы, и мы рекомендуем вам периодически пересматривать данные Положения, чтобы быть информированными о том, как мы используем ваши ПД для распространения.</span></li>
        </ul>

        <p class="label label_bold">5. Контакты</p>
        <ul class="ul-clear">
            <li>5.1. <span>Если у вас есть какие-либо вопросы, проблемы или предложения относительно данного Положения, пожалуйста, свяжитесь с нами по электронной почте hello@dune.com</span></li>
        </ul>
    </main>

    {{-- Extra styles --}}
    <style>
        body {
            background: #FFF9EE;
        }
    </style>
@endsection
