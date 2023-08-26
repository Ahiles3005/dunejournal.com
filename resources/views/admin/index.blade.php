@extends('admin.components.wrapper')

@section('content')
    @if ( empty(session('admin_authed')) )
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-lg-4 mx-auto mt-3">
                    <h2 class="text-center">Авторизация</h2>
                    <form action="{{ route('admin.auth') }}" method="POST">
                        <div class="input-group mb-3 mt-3">
                            <span class="input-group-text">Логин</span>
                            <input type="text" name="login" class="form-control" placeholder="Введите логин" required>
                        </div>
                        <div class="input-group mb-3 mt-3">
                            <span class="input-group-text">Пароль</span>
                            <input type="password" name="pass" class="form-control" placeholder="Введите пароль" required>
                        </div>

                        @csrf

                        <button class="btn btn-success w-100">Авторизоваться</button>
                    </form>

                </div>
            </div>
        </div>
    @else
        <h3 class="text-center my-5 mx-2">
            Добро пожаловать, @php echo env('ADMIN_LOGIN') @endphp!
            <br>
            Выберите требуемый раздел для упрваления сайтом.
        </h3>
    @endif
@endsection
