@extends('layouts.main')

@section('content')

<div class="container-lg bg-light p-4">
    <h1 class="fs-3 mb-3">Результаты поиска: <b>{{ $query }}</b></h1>
    <a href="{{ url()->previous() }}" class="btn-user btn-user-logout btn btn-primary btn-md">
        Назад
        <svg style="margin-top: -2px" class="ms-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-reply-fill" viewBox="0 0 16 16">
            <path d="M5.921 11.9 1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z"/>
        </svg>
    </a>

</div>

<div class="container-lg mt-4 bg-light">
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
                        <td class="p-4">
                            @forelse($item->tags as $attachedItem) 
                                <button class="btn btn-primary">{{ $attachedItem->title }}</button>
                            @empty
                                Нет
                            @endforelse
                        </td>
                        <td class="p-4">{{ $item->created_at }}</td>
                    </tr>
                    @empty
                    <div class="row pt-4 pb-4 empty-list">
                        <div class="col-2 m-auto d-flex text-center flex-column">  
                            <svg class="mt-3" style="display: block; margin: 0 auto" xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-braces" viewBox="0 0 16 16">
                                <path d="M2.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C3.25 2 2.49 2.759 2.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6zM13.886 7.9v.163c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456V7.332c-1.114 0-1.49-.362-1.49-1.456V4.352C13.51 2.759 12.75 2 11.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6z"/>
                            </svg>
                            <p class="mt-3 fs-5">Ничего не найдено</p>
                        </div>
                    </div>
                    @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection