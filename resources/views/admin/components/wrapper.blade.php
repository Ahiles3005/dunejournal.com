<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DUNE | @yield('title', 'Админпанель')</title>
    <link rel="stylesheet" href="{{ mix('assets/css/admin/admin.css') }}">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.page.index') }}">DUNE [Admin]</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop"
                aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTop">
                @if ( !empty(session('admin_authed')) )

                    <ul class="navbar-nav ms-auto me-3">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.page.news') }}">Новости</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.page.tags') }}">Тэги</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.page.categories') }}">Тематики</a>
                        </li>
                    </ul>

                    <a href="{{ route('admin.logout') }}"><button class="btn btn-danger">Выйти</button></a>

                @endif
            </div>
        </div>
    </nav>

    @yield('content')

    @include('admin.components.footer')
</body>

</html>
