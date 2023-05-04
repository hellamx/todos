<tr class="just-added" style="display: none">
    <th class="p-4">{{ $todo->title }}</th>
    <td class="p-4"></td>
    <td class="p-4 d-flex justify-content-end">
        
        <!-- Кнопки навигации истории списков -->
        
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