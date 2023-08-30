@extends('admin.components.wrapper')

@section('title', 'Тематики')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <h3 class="text-center">Управление тематиками</h3>
            </div>

            <div class="col-12 text-center mb-3">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#categories-add-popup"><i class="fa-regular fa-square-plus"></i> Добавить тематику</button>
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
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}
                                    </td>
                                    <td>
                                        <button class="btn btn-warning info-category" data-bs-toggle="modal" data-bs-target="#category-popup" data-id="{{ $category->id }}">Управление</button>
                                        <button class="btn btn-danger del-category" data-id="{{ $category->id }}">Удалить</button>
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

    <div class="modal fade" id="category-popup" tabindex="-1">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Управление тематикой</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" method="POST" action="{{ route('admin.category.edit') }}">

                    @csrf

                    <div class="input-group mb-3">
                        <span class="input-group-text">Название</span>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">ЧПУ</span>
                        <input type="text" name="slug" class="form-control">
                    </div>

                    <input type="hidden" name="id">

                    <button class="btn btn-success w-100 mt-4">Сохранить</button>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="categories-add-popup" tabindex="-1">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить тематику</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" method="POST" action="{{ route('admin.category.add') }}">

                    @csrf

                    <div class="input-group mb-3">
                        <span class="input-group-text">Название</span>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">ЧПУ</span>
                        <input type="text" name="slug" class="form-control">
                    </div>

                    <button class="btn btn-success w-100 mt-4">Сохранить</button>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="categories-remove-popup" tabindex="-1">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Подтвердите действие</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @csrf

                    <p class="alert alert-danger text-center">Вы действительно хотите удалить тематику?
                        <br>
                        <br>
                        <strong>*ВАЖНО!</strong> Тематика также уберётся с новостей, где используется!
                    </p>

                    <button class="btn btn-danger w-100 mt-2" id="delete-entity">УДАЛИТЬ</button>
                </div>

            </div>
        </div>
    </div>

@endsection
