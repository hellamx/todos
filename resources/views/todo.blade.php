@extends('layouts.main')

@section('content')
<div class="container-lg bg-light p-4">
    <h1 class="fs-3 mb-3">Список <b>{{ $todo->title }}</b></h1>
    <button class="btn-user btn btn-primary btn-md me-1" data-bs-toggle="modal" data-bs-target="#item" type="button">
        Добавить пункт
        <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-plus-square" viewBox="0 0 16 16">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>
    </button>
    <button class="btn-user btn btn-primary btn-md me-1" data-bs-toggle="modal" data-bs-target="#tag" type="button">
        Добавить тег
        <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-plus-square" viewBox="0 0 16 16">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>
    </button>
    <button class="btn-user btn btn-primary btn-md me-1" data-bs-toggle="modal" data-bs-target="#taglist" type="button">
        Список тегов
        <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-list-ul" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
        </svg>
    </button>
    <a href="{{ route('dashboard') }}" class="btn-user btn-user-logout btn btn-primary btn-md">
        На главную
        <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-house-door" viewBox="0 0 16 16">
            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146ZM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5Z"/>
        </svg>
    </a>

    <!-- Модальное окно создания пункта списка -->
    <div class="modal fade" id="item" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Добавление нового пункта</h1>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('item.store', $todo->slug) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="title_item" class="form-label">Заголовок</label>
                            <input type="text" class="form-control" name="title" id="title_item">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" id="modal-item" class="btn user-modal-submit">Добавить</button>
                            <button type="button" class="btn user-modal-close" data-bs-dismiss="modal">Закрыть</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно добавления тега -->
    <div class="modal fade" id="tag" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Добавление тега</h1>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('tag.store') }}">
                        @csrf
                        <input type="hidden" name="todo_id" value="{{ $todo->id }}">
                        <div class="mb-3">
                            <label for="title_item" class="form-label">Заголовок</label>
                            <input type="text" class="form-control" name="title" id="title_item">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" id="modal-item" class="btn user-modal-submit">Добавить</button>
                            <button type="button" class="btn user-modal-close" data-bs-dismiss="modal">Закрыть</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно списка тегов -->
    <div class="modal fade" id="taglist" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Список тегов</h1>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                        @forelse($tags as $tag)
                            <tr>
                                <td>{{ $tag->title }}</td>
                                <td class="d-flex justify-content-end">
                                    <form action="{{ route('tag.destroy') }}" method="post">
                                        @csrf 
                                        @method('DELETE')
                                        <input type="hidden" name="tag_id" value="{{ $tag->id }}">
                                        <button type="submit" class="btn btn-danger">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                        <div class="d-flex flex-column m-auto align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" fill="currentColor" class="bi bi-cloud-slash-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M3.112 5.112a3.125 3.125 0 0 0-.17.613C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13H11L3.112 5.112zm11.372 7.372L4.937 2.937A5.512 5.512 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773a3.2 3.2 0 0 1-1.516 2.711zm-.838 1.87-12-12 .708-.708 12 12-.707.707z"/>
                            </svg>
                            <p class="mt-2 fs-6">Теги не добавлены</p>
                        </div>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex mt-3 justify-content-between">
                        <button type="button" class="btn user-modal-close" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Форма поиска -->
<div class="container-lg pt-4 ps-0 pe-0">
    <form method="get" action="{{ route('item.search') }}" autocomplete="off" class="d-flex mb-0 justify-content-between search-form">
        <div class="col-10">
            <input type="hidden" id="todo_id" name="todo_id" value="{{ $todo->id }}">
            <input type="text" id="typeahead" name="s" class="form-control input-search typeahead" id="search" placeholder="Введите ключевые слова">
        </div>
        <div class="col-2">
          <button type="submit" class="d-block w-100 btn item-search-btn mb-0">Поиск</button>
        </div>
      </form>
</div>

<!-- Фильтрация по тегам -->

<div class="container-lg pt-4 ps-0 pe-0">
    <p class="fs-5">Фильтрация по тегам</p>
    <form id="filter-form" class="d-flex" method="post" action="{{ route('tag.filter') }}">
        @csrf
        @forelse($todo->tags as $tag)
            <input type="hidden" name="todo_id" value="{{ $todo->id }}">
            <input style="display: none" name="tag-{{ $tag->title }}" value="{{ $tag->id }}" id="checkbox-{{ $tag->id }}" type="checkbox">
            <label class="me-2" for="checkbox-{{ $tag->id }}">
                <p class="btn tag-checkbox mb-0">{{ $tag->title }}</p>
            </label>
            @empty
            Теги не добавлены
        @endforelse
    </form>
</div>

<!-- Вывод уведомлений -->
@include('layouts.alerts')

<div class="main-container container-lg mt-4 bg-light">
    <div class="row list-table">
        <div class="header-lists p-4">
            <h2 class="fs-5 mb-0">Пункты списка</h2>
        </div>
            <table class="table mt-0 mb-0">
                @if(!$items->isEmpty())
                    <thead>
                        <tr>
                        <th class="p-4" scope="col">Заголовок</th>
                        <th class="p-4" scope="col">Изображение</th>
                        <th class="p-4" scope="col">Теги</th>
                        <th class="p-4" scope="col">Дата создания</th>
                        <th class="p-4 d-flex justify-content-end" scope="col">Управление</th>
                        </tr>
                    </thead>
                @endif
                <tbody>
                        
                    @forelse($items as $item)
                    <tr>
                        <th class="p-4">{{ $item->title }}</th>
                        <td class="p-4">
                        @if($item->img_preview)
                            <a href="{{ route('dashboard') }}/public/images/{{ $item->img_full }}" target="_blank">
                                <img src="{{ route('dashboard') }}/public/images/{{ $item->img_preview }}" alt="{{ $item->title }}">
                            </a>
                        @else
                            Не добавлено
                        @endif
                        </td>
                        <!-- Вывод тегов -->
                        <td class="p-4">
                            @forelse($item->tags as $attachedItem) 
                                <button class="btn btn-primary">{{ $attachedItem->title }}</button>
                            @empty
                            Нет
                            @endforelse
                        </td>
                        <td class="p-4">{{ $item->created_at }}</td>
                        <td class="p-4 d-flex justify-content-end">
                                    
                            <!-- Кнопки навигации списков -->

                            <button id="complete-list" type="button" data-bs-toggle="modal" data-bs-target="#image-{{ $item->id }}" class="btn btn-primary ms-2"
                                    style="height:100%; --bs-btn-padding-y: .25rem; --bs-btn-padding-x: 1rem; --bs-btn-font-size: 14px; border-radius: 20px">
                                Изображение
                                <svg class="ms-1" style="margin-top:-2px" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#fff" class="bi bi-image" viewBox="0 0 16 16">
                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                                </svg>
                            </button>

                            <!-- Модальное окно для управления изображением -->
                            <div class="modal fade" id="image-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Управление изображением</h1>
                                        </div>
                                        <div class="modal-body">
                                            @if($item->img_preview)
                                                <h2 class="fs-4">Загрузить новое изображение</h2>
                                            @endif
                                            <form enctype="multipart/form-data" method="post" action="{{ route('image.upload', $item->id) }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="formFile" class="form-label">Выберите изображение</label>
                                                    <input class="form-control" name="image" type="file" id="formFile">
                                                        <div class="form-text">Рекомендуемое соотношение сторон - 1:1</div>
                                                        <div class="form-text">Поддерживаемые форматы: jpg/jpeg, png, webp</div>
                                                        <div class="form-text">Максимальный размер файла: 1 МБ</div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <button style="width: 49%" type="submit" class="btn user-modal-submit">Загрузить</button>
                                                    <button style="width: 49%" type="button" class="btn user-modal-close" data-bs-dismiss="modal">Закрыть</button>
                                                </div>
                                            </form>
                                            @if($item->img_preview)
                                                <form method="post" action="{{ route('image.destroy') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <div class="d-grid gap-2">
                                                        <button class="btn btn-danger" type="submit">Удалить изображение</button>
                                                    </div>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button id="complete-list" type="button" data-bs-toggle="modal" data-bs-target="#attach-{{$item->id}}" class="btn btn-dark ms-2"
                                style="height:100%; --bs-btn-padding-y: .25rem; --bs-btn-padding-x: 1rem; --bs-btn-font-size: 14px; border-radius: 20px">
                                Прикрепить тег
                                <svg class="ms-1" style="margin-top:-2px" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#fff" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>
                            </button>

                            <!-- Модальное окно списка тегов -->
                            <div class="modal fade" id="attach-{{$item->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Прикрепить тег к пункту списка</h1>
                                        </div>
                                        <div class="modal-body">
                                            @if(!$tags->isEmpty())
                                            <form action="{{ route('tag.attach') }}" method="post">
                                                @csrf
                                                <label class="mb-2" for="tagAttach">Выбрать из списка: </label>
                                                <select style="border: 1px solid #5B569A" class="form-control" name="tag" id="tagAttach">
                                                    <option selected disabled>Выбрать</option>
                                                    @foreach($tags as $tag)
                                                    <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <div class="d-flex mt-3 justify-content-between">
                                                    <button type="submit" class="btn user-modal-submit" data-bs-dismiss="modal">Прикрепить</button>
                                                    <button type="button" class="btn user-modal-close" data-bs-dismiss="modal">Закрыть</button>
                                                </div>
                                            </form>
                                            @else 
                                            <div class="d-flex flex-column m-auto align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" fill="currentColor" class="bi bi-cloud-slash-fill" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M3.112 5.112a3.125 3.125 0 0 0-.17.613C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13H11L3.112 5.112zm11.372 7.372L4.937 2.937A5.512 5.512 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773a3.2 3.2 0 0 1-1.516 2.711zm-.838 1.87-12-12 .708-.708 12 12-.707.707z"/>
                                                </svg>
                                                <p class="mt-2 fs-6">Теги не добавлены</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        
                            <form action="{{ route('item.destroy') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-danger ms-2"
                                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: 1rem; --bs-btn-font-size: 14px; border-radius: 20px">
                                    Удалить
                                    <svg class="ms-1" style="margin-top:-2px" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#fff" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                    </svg>
                                </button> 
                            </form> 
                        </td>  
                    </tr>
                    @empty
                    <div class="row pt-4 pb-4 empty-list">
                        <div class="col-2 m-auto d-flex text-center flex-column">  
                            <svg class="mt-3" style="display: block; margin: 0 auto" xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-braces" viewBox="0 0 16 16">
                                <path d="M2.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C3.25 2 2.49 2.759 2.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6zM13.886 7.9v.163c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456V7.332c-1.114 0-1.49-.362-1.49-1.456V4.352C13.51 2.759 12.75 2 11.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6z"/>
                            </svg>
                            <p class="mt-3 fs-5">Пунктов еще нет</p>
                        </div>
                    </div>
                    @endforelse
            </tbody>
        </table>
    </div>
    <div class="loader">
        <div class="loader-item loadingio-spinner-rolling-f0ttsj4mh5k"><div class="ldio-p5j7iazla8n">
            <div></div>
            </div></div>
            <style type="text/css">
            @keyframes ldio-p5j7iazla8n {
              0% { transform: translate(-50%,-50%) rotate(0deg); }
              100% { transform: translate(-50%,-50%) rotate(360deg); }
            }
            .ldio-p5j7iazla8n div {
              position: absolute;
              width: 85.95px;
              height: 85.95px;
              border: 9.549999999999999px solid #5b569a;
              border-top-color: transparent;
              border-radius: 50%;
            }
            .ldio-p5j7iazla8n div {
              animation: ldio-p5j7iazla8n 0.641025641025641s linear infinite;
              top: 95.5px;
              left: 95.5px
            }
            .loadingio-spinner-rolling-f0ttsj4mh5k {
              width: 191px;
              height: 191px;
              display: inline-block;
              overflow: hidden;
            }
            .ldio-p5j7iazla8n {
              width: 100%;
              height: 100%;
              position: relative;
              transform: translateZ(0) scale(1);
              backface-visibility: hidden;
              transform-origin: 0 0; /* see note above */
            }
            .ldio-p5j7iazla8n div { box-sizing: content-box; }/
            </style>
    </div>
</div>
@endsection