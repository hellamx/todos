@extends('layouts.main')

@section('content')


@guest
<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
       
        <!-- Навигация -->    
        <h1 class="display-5 fw-bold">Todo's - список дел и задач</h1>
        <p class="col-md-8 fs-4">Создавайте, делитесь и управляйте своими задачами</p>
        <button class="btn-user btn btn-primary btn-md me-1" type="button" data-bs-toggle="modal" data-bs-target="#login">Регистрация</button>
        <button class="btn-user btn btn-primary btn-md" type="button" data-bs-toggle="modal" data-bs-target="#register">Авторизация</button>
            
         <!-- Модальное окно регистрации -->
        <div class="modal fade" id="login" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Регистрация пользователя</h1>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('user.store') }}">
                            <!-- Поля для вывода уведомлений от Ajax -->
                            @include('layouts.modal-alerts')
                            @csrf
                            <div class="mb-3">
                                <label for="name_register" class="form-label">Имя пользователя</label>
                                <input type="text" class="form-control" name="name" id="name_register">
                                <div class="form-text">Не менее 4 и не более 25 символов</div>
                            </div>
                            <div class="mb-3">
                                <label for="password_register" class="form-label">Пароль</label>
                                <input type="password" class="form-control" name="password" id="password_register">
                                <div class="form-text">Не менее 6 символов</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" id="modal-register" class="btn user-modal-submit">Регистрация</button>
                                <button type="button" class="btn user-modal-close" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно авторизации -->
        <div class="modal fade" id="register" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Авторизация пользователя</h1>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('user.login') }}">
                            <!-- Поля для вывода уведомлений от Ajax -->
                            @include('layouts.modal-alerts')
                            @csrf
                            <div class="mb-3">
                                <label for="name_login" class="form-label">Имя пользователя</label>
                                <input type="text" class="form-control" name="name" id="name_login">
                            </div>
                            <div class="mb-3">
                                <label for="password_login" class="form-label">Пароль</label>
                                <input type="password" name="password" class="form-control" id="password_login">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" id="modal-login" class="btn user-modal-submit">Авторизация</button>
                                <button type="button" class="btn user-modal-close" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endguest

@auth
<div class="container-lg bg-light p-4">
    
    <h1 class="fs-3 mb-3">Добрый день, {{ Auth::user()->name }}</h1>
    <button class="btn-user btn btn-primary btn-md me-1" data-bs-toggle="modal" data-bs-target="#list" type="button">
        Создать список
        <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-plus-square" viewBox="0 0 16 16">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>
    </button>
    <a href="{{ route('user.logout') }}" class="btn-user btn-user-logout btn btn-primary btn-md">
        Выход
        <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-arrow-right-square" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
        </svg>
    </a>

    <!-- Модальное окно создания списка -->
    <div class="modal fade" id="list" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Создание нового списка</h1>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('todo.store') }}">
                        <!-- Поля для вывода уведомлений от Ajax -->
                        @include('layouts.modal-alerts')
                        @csrf
                        <div class="mb-3">
                            <label for="title_list" class="form-label">Заголовок</label>
                            <input type="text" class="form-control" name="title" id="title_list">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" id="modal-list" class="btn user-modal-submit">Добавить</button>
                            <button type="button" class="btn user-modal-close" data-bs-dismiss="modal">Закрыть</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="container-lg mt-4 bg-light">
    <div class="row list-table">
        <div class="header-lists p-4">
            <h2 class="fs-5 mb-0">Мои списки</h2>
        </div>
            <table class="table mt-0 mb-0">
                <tbody>
                        
                @forelse($todos as $todo)
                    <tr>
                        <th class="p-4"><a class="user-list-link" href="{{ route('todo.page', $todo->slug) }}">{{ $todo->title }}</a></th>
                        <td class="p-4">{{ $todo->created_at }}</td>
                        <td class="p-4 d-flex justify-content-end">
                                    
                            <!-- Кнопки навигации списков -->

                            <button type="button" data-bs-toggle="modal" data-bs-target="#edit-{{$todo->id}}" class="btn btn-dark me-2"
                                style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: 1rem; --bs-btn-font-size: 14px; border-radius: 20px">
                                Редактировать
                                <svg class="ms-1" style="margin-top:-2px" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#fff" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg>
                            </button>

                            <!-- Модальное окно редактирования списка -->
                            <div class="modal fade" id="edit-{{ $todo->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Редактирование списка</h1>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{ route('todo.update') }}">
                                                <!-- Поля для вывода уведомлений от Ajax -->
                                                @include('layouts.modal-alerts')
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $todo->id }}">
                                                <div class="mb-3">
                                                    <label for="title_edit" class="form-label">Заголовок</label>
                                                    <input type="text" class="form-control" name="title" value="{{ $todo->title }}" id="title_edit">
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <button type="submit" id="modal-edit" class="btn user-modal-submit">Сохранить</button>
                                                    <button type="button" class="btn user-modal-close" data-bs-dismiss="modal">Закрыть</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('todo.complete') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $todo->id }}">
                                <button id="complete-list" type="button" class="btn btn-success ms-2"
                                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: 1rem; --bs-btn-font-size: 14px; border-radius: 20px">
                                    Выполнено
                                    <svg class="ms-1" style="margin-top:-2px" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#fff" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                </button>
                            </form> 
                                    
                            <form action="{{ route('todo.destroy') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $todo->id }}">
                                <button id="delete-list" type="submit" class="btn btn-danger ms-2"
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
                            <p class="mt-3 fs-5">Список пуст</p>
                        </div>
                    </div>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

<!-- Блок с историей списков -->
<div class="container-lg mt-4 bg-light">
    <div class="row history-table">
        <div class="header-lists-history p-4">
            <h2 class="fs-5 mb-0">История</h2>
        </div>
        <table class="table mt-0 mb-0">
            <tbody>

            @forelse($history as $historyItem)
                <tr>
                    <th class="p-4">{{ $historyItem->title }}</th>
                    <td class="p-4">{{ $historyItem->create_at }}</td>
                    <td class="p-4 d-flex justify-content-end">
                                    
                        <!-- Кнопки навигации истории списков -->
                                        
                        <form action="{{ route('todo.destroy') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $historyItem->id }}">
                            <button id="delete-list" type="submit" class="btn btn-danger ms-2"
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
                <div class="row pt-4 pb-4 empty-history">
                    <div class="col-2 m-auto d-flex text-center flex-column">
                        <svg class="mt-3" style="display: block; margin: 0 auto" xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-lightbulb-off" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.23 4.35A6.004 6.004 0 0 0 2 6c0 1.691.7 3.22 1.826 4.31.203.196.359.4.453.619l.762 1.769A.5.5 0 0 0 5.5 13a.5.5 0 0 0 0 1 .5.5 0 0 0 0 1l.224.447a1 1 0 0 0 .894.553h2.764a1 1 0 0 0 .894-.553L10.5 15a.5.5 0 0 0 0-1 .5.5 0 0 0 0-1 .5.5 0 0 0 .288-.091L9.878 12H5.83l-.632-1.467a2.954 2.954 0 0 0-.676-.941 4.984 4.984 0 0 1-1.455-4.405l-.837-.836zm1.588-2.653.708.707a5 5 0 0 1 7.07 7.07l.707.707a6 6 0 0 0-8.484-8.484zm-2.172-.051a.5.5 0 0 1 .708 0l12 12a.5.5 0 0 1-.708.708l-12-12a.5.5 0 0 1 0-.708z"/>
                        </svg>
                        <p class="mt-3 fs-5">История пуста</p>
                    </div>
                </div>
            @endforelse
                    
            </tbody>
        </table>
    </div>
</div>
@endauth

@endsection