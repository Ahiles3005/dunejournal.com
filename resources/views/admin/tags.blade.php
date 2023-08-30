@extends('admin.components.wrapper')

@section('title', 'Тэги')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <h3 class="text-center">Управление тэгами</h3>
            </div>

            <div class="col-12 text-center mb-3">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tags-add-popup"><i class="fa-regular fa-square-plus"></i> Добавить тэг</button>
            </div>

            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead>
                        <tr>
                            <th>SITE ID</th>
                            <th>Название</th>
                            <th>Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $tag)
                                <tr>
                                    <td>{{ $tag->id }}</td>
                                    <td>{{ $tag->name }}
                                        @if ($tag->is_hot)
                                            <span class="badge bg-success"><i class="fa-solid fa-check"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-warning info-tag" data-bs-toggle="modal" data-bs-target="#tag-popup" data-id="{{ $tag->id }}">Управление</button>
                                        <button class="btn btn-danger del-tag" data-id="{{ $tag->id }}">Удалить</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @csrf
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tag-popup" tabindex="-1">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Управление тэгом</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" method="POST" action="{{ route('admin.tag.edit') }}">

                    @csrf

                    <div class="input-group mb-3">
                        <span class="input-group-text">Название</span>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">ЧПУ</span>
                        <input type="text" name="slug" class="form-control">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Цвет при наведении</span>
                        <input type="text" name="hover_color" class="form-control" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Закрепить в интересных?</span>
                        <select name="is_hot" class="form-control" required>
                            <option value="0">Нет</option>
                            <option value="1">Да</option>
                        </select>
                    </div>

                    <input type="hidden" name="id">

                    <button class="btn btn-success w-100 mt-4">Сохранить</button>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tags-add-popup" tabindex="-1">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить тэг</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" method="POST" action="{{ route('admin.tag.add') }}">

                    @csrf

                    <div class="input-group mb-3">
                        <span class="input-group-text">Название</span>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">ЧПУ</span>
                        <input type="text" name="slug" class="form-control">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Цвет при наведении</span>
                        <input type="text" name="hover_color" class="form-control" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Закрепить в интересных?</span>
                        <select name="is_hot" class="form-control" required>
                            <option value="0">Нет</option>
                            <option value="1">Да</option>
                        </select>
                    </div>

                    <button class="btn btn-success w-100 mt-4">Сохранить</button>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tags-remove-popup" tabindex="-1">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Подтвердите действие</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @csrf

                    <p class="alert alert-danger text-center">Вы действительно хотите удалить текущий тэг?
                        <br>
                        <br>
                        <strong>*ВАЖНО!</strong> Тэг также уберётся с новостей, где используется!
                    </p>

                    <button class="btn btn-danger w-100 mt-2" id="delete-entity">УДАЛИТЬ</button>
                </div>

            </div>
        </div>
    </div>

@endsection
