@extends('admin.components.wrapper')

@section('title', 'Новости')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <h3 class="text-center">Управление новостями</h3>
            </div>

            <div class="col-12 text-center mb-3">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#news-add-popup"><i class="fa-regular fa-square-plus"></i> Добавить новость</button>
            </div>

            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead>
                        <tr>
                            <th>SITE ID</th>
                            <th>Краткое описание</th>
                            <th>Дата создания</th>
                            <th>Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($news as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->short_descr }}</td>
                                    <td><span class="badge bg-primary">{{ $item->created_at }}</span></td>
                                    <td>
                                        <button class="btn btn-warning info-news" data-bs-toggle="modal" data-bs-target="#news-popup" data-id="{{ $item->id }}">Управление</button>
                                        <button class="btn btn-danger del-news" data-id="{{ $item->id }}">Удалить</button>
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

    <div class="modal fade" id="news-popup" tabindex="-1">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Управление новостью</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="news-edit" method="POST" action="{{ route('admin.news.edit') }}" enctype="multipart/form-data">

                    @csrf

                    <div class="input-group align-items-center mb-1">
                        <span class="input-group-text">Главное Фото / Видео</span>
                        <input type="file" name="asset" class="form-control" accept="image/*,video/*">
                        <button type="button" class="btn btn-danger del-asset"><i class="fa-regular fa-trash-can"></i></button>
                        <div class="current-asset w-100 mx-3 my-2"></div>
                    </div>

                    <div class="input-group align-items-center mb-1">
                        <span class="input-group-text">(FULL MODE) Главное фото</span>
                        <input type="file" name="full_image" class="form-control" accept="image/*">
                        <button type="button" class="btn btn-danger del-full_image"><i class="fa-regular fa-trash-can"></i></button>
                        <div class="current-full_image w-100 mx-3 my-2"></div>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Тип отображения новости</span>
                        <select name="type" class="form-control" required>
                            <option value="standart" selected>Карточка маленькая (2 в ряд)</option>
                            <option value="hot">Карточка большая (1 в ряд)</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Краткое описание</span>
                        <textarea name="short_descr" class="form-control" placeholder="Краткое описание" rows="5" required></textarea>
                    </div>

                    <span class="badge bg-info w-100 text-center mb-1">Полное описание:</span>

                    <div class="input-group mb-3">
                        <textarea name="full_descr" class="form-control description-edit" placeholder="Полное описание" rows="5" required></textarea>
                    </div>

                    <span class="badge bg-info mb-1 w-100">Тэги</span>
                    <select name="tags[]" class="select-fullwidth" multiple="multiple" required>
                        @foreach ($tags as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>

                    <span class="badge bg-info mt-3 mb-1 w-100">Тематики</span>

                    <select name="categories[]" class="select-fullwidth" multiple="multiple" required>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>

                    <div class="input-group align-items-center mt-3 mb-1">
                        <span class="input-group-text">Галерея</span>
                        <input type="file" name="gallery" class="form-control" accept="image/*" multiple>
                        <div class="current-gallery w-100 mx-3 my-2 d-flex flex-wrap"></div>
                    </div>

                    <input type="hidden" name="del_asset" value="0">
                    <input type="hidden" name="del_full_image" value="0">

                    <input type="hidden" name="id">

                    <button class="btn btn-success w-100 mt-4">Сохранить</button>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="news-add-popup" tabindex="-1">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить новость</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" id="news-add" method="POST" action="{{ route('admin.news.add') }}" enctype="multipart/form-data">

                    @csrf

                    <div class="input-group align-items-center mb-1">
                        <span class="input-group-text">Главное Фото / Видео</span>
                        <input type="file" name="asset" class="form-control" accept="image/*,video/*">
                        <button type="button" class="btn btn-danger del-asset"><i class="fa-regular fa-trash-can"></i></button>
                        <div class="current-asset w-100 mx-3 my-2"></div>
                    </div>

                    <div class="input-group align-items-center mb-1">
                        <span class="input-group-text">(FULL MODE) Главное фото</span>
                        <input type="file" name="full_image" class="form-control" accept="image/*">
                        <button type="button" class="btn btn-danger del-full_image"><i class="fa-regular fa-trash-can"></i></button>
                        <div class="current-full_image w-100 mx-3 my-2"></div>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Тип отображения новости</span>
                        <select name="type" class="form-control" required>
                            <option value="standart" selected>Карточка маленькая (2 в ряд)</option>
                            <option value="hot">Карточка большая (1 в ряд)</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Краткое описание</span>
                        <textarea name="short_descr" class="form-control" placeholder="Краткое описание" rows="5" required></textarea>
                    </div>

                    <span class="badge bg-info w-100 text-center mb-1">Полное описание:</span>

                    <div class="input-group mb-3">
                        <textarea name="full_descr" class="form-control description" placeholder="Полное описание" rows="5" required></textarea>
                    </div>

                    <span class="badge bg-info mb-1 w-100">Тэги</span>
                    <select name="tags[]" class="select-fullwidth" multiple="multiple" required>
                        @foreach ($tags as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>

                    <span class="badge bg-info mt-3 mb-1 w-100">Тематики</span>

                    <select name="categories[]" class="select-fullwidth" multiple="multiple" required>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>

                    <div class="input-group align-items-center mt-3 mb-1">
                        <span class="input-group-text">Галерея</span>
                        <input type="file" name="gallery" class="form-control" accept="image/*" multiple>
                        <div class="current-gallery w-100 mx-3 my-2 d-flex flex-wrap"></div>
                    </div>

{{--                     <input type="hidden" name="del_asset" value="0">
                    <input type="hidden" name="del-full_image" value="0"> --}}

                    <button class="btn btn-success w-100 mt-4">Сохранить</button>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="news-remove-popup" tabindex="-1">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Подтвердите действие</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @csrf

                    <p class="alert alert-danger text-center">Вы действительно хотите удалить новость?
                    </p>

                    <button class="btn btn-danger w-100 mt-2" id="delete-entity">УДАЛИТЬ</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('extra_js')
    <script>
        $(function(){
            $('.description').richText({
                imageUpload: true,
                fileUpload: false,
                videoEmbed: true,
                fonts: false,
                backgroundColor: false,
                // placeholder: 'Введите описание вакансии',
            });

            $('.description-edit').richText({
                imageUpload: true,
                fileUpload: false,
                videoEmbed: true,
                fonts: false,
                backgroundColor: false,
                // placeholder: 'Введите описание вакансии',
            });

            $('#news-add-popup .select-fullwidth').select2({
                width: '100%',
                dropdownParent: $('#news-add-popup .modal-content')
            });

            $('#news-popup .select-fullwidth').select2({
                width: '100%',
                dropdownParent: $('#news-popup .modal-content')
            });
        });
    </script>
@endsection
