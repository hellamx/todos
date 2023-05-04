<tr class="just-added" style="display: none">
    <th class="p-4"><a class="user-list-link" href="{{ route('todo.page', $todo->slug) }}">{{ $todo->title }}</a></th>
    <td class="p-4">{{ $todo->created_at }}</td>
    <td class="p-4 d-flex justify-content-end">
    
        <!-- Кнопки навигации списков -->

        <button type="button" data-bs-toggle="modal" data-bs-target="#edit-{{ $todo->id }}" class="btn btn-dark me-2"
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