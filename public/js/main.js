// Модальное окно регистрации

$('#modal-register').click((e) => {
    e.preventDefault();

	const name = $(e.currentTarget).closest('form').find('input[name="name"]').val();
	const password = $(e.currentTarget).closest('form').find('input[name="password"]').val();
	const token = $(e.currentTarget).closest('form').find('input[name="_token"]').val();
    const path = window.location.protocol + '//' + window.location.hostname;

    $.ajax({
        url: path + '/user/signup',
        data: {name: name, password: password},
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        success: function(result) {
            
            if (result.validate == false) {

                $(e.currentTarget).closest('form').find('.modal-success').html('');
                $(e.currentTarget).closest('form').find('.modal-error').html(result.message);

            } else {
                
                $(e.currentTarget).closest('form').find('.modal-error').html('');
                $(e.currentTarget).closest('form').find('.modal-success').html('Успешно <br> Перенаправление...');

                window.setTimeout(function() {
                    
                    location.reload();
                
                }, 2000);
            }

        },
        error: function() {
            console.log('Server error');
        }
    });
});

// Модальное окно авторизации

$('#modal-login').click((e) => {
    e.preventDefault();

    // Получение данных
	const name = $(e.currentTarget).closest('form').find('input[name="name"]').val();
	const password = $(e.currentTarget).closest('form').find('input[name="password"]').val();
	const token = $(e.currentTarget).closest('form').find('input[name="_token"]').val();
    const path = window.location.protocol + '//' + window.location.hostname;

    $.ajax({
        url: path + '/user/login',
        data: {name: name, password: password},
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        success: function(result) {
            
            if (result.validate == false) {

                // Вывод ошибок
                $(e.currentTarget).closest('form').find('.modal-error').html(result.message);

            } else {

                // Перезагрузка страницы, если авторизация успешна
                location.reload();
            
            }

        },
        error: function() {
            console.log('Server error');
        }
    });
});

// Модальное окно с добавлением списка

$('#modal-list').click((e) => {
    e.preventDefault();

    // Получение данных
	const title = $(e.currentTarget).closest('form').find('input[name="title"]').val();
	const token = $(e.currentTarget).closest('form').find('input[name="_token"]').val();
    const path = window.location.protocol + '//' + window.location.hostname;

    $.ajax({
        url: path + '/todo/create',
        data: {title: title},
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        success: function(result) {
            
            if (result.validate == false) {

                // Вывод ошибок
                $(e.currentTarget).closest('form').find('.modal-error').html(result.message);

            } else {

                // Если это первый список, то изначально удаляем блок "Список пуст"
                if ($('*').is('.empty-list')) {
                    $('.empty-list').remove();

                    // Добавление нового элемента в DOM и плавное появление
                    $('.list-table table tbody').prepend(result.html);
                    $('.just-added').show(300);
                } else {

                    // Добавление нового элемента в DOM и плавное появление
                    $('.list-table table tbody').prepend(result.html);
                    $('.just-added').show(300);

                }

                // Очистка данных из формы и скрытие модального окна
                $(".modal").modal('hide');
                $(e.currentTarget).closest('form').find('.modal-error').html('');
                $(e.currentTarget).closest('form').find('input[name="title"]').val('');
            }
            
        },
        error: function() {
            console.log('Server error');
        }
    });
});

// Удаление списка

$('body').on('click', '#delete-list', (e) => {
    e.preventDefault();

    // Получение данных
	const id = $(e.currentTarget).closest('form').find('input[name="id"]').val();
	const token = $(e.currentTarget).closest('form').find('input[name="_token"]').val();
	const method = $(e.currentTarget).closest('form').find('input[name="_method"]').val();
    const path = window.location.protocol + '//' + window.location.hostname;

    $.ajax({
        url: path + '/todo/delete',
        data: {id: id, '_method': method},
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        success: function(result) {
            
            if (result.proccess == true) {

                $(e.currentTarget).closest('tr').hide(300, () => {
                    $(e.currentTarget).closest('tr').remove();
                })

                // Если была удалена последняя запись, то вставляем блок "Список пуст"
                if ($('.list-table table tr').length <= 1 && $(e.currentTarget).closest('.row').hasClass('list-table')) {
                    
                    $('.header-lists').after("<div style='display: none' class='row pt-4 pb-4 empty-list'> \
                                                <div class='col-2 m-auto d-flex text-center flex-column'> \
                                                    <svg class='mt-3' style='display: block; margin: 0 auto' xmlns='http://www.w3.org/2000/svg' width='64' height='64' fill='currentColor' viewBox='0 0 16 16'> \
                                                        <path d='M2.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C3.25 2 2.49 2.759 2.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6zM13.886 7.9v.163c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456V7.332c-1.114 0-1.49-.362-1.49-1.456V4.352C13.51 2.759 12.75 2 11.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6z'></path> \
                                                    </svg> \
                                                    <p class='mt-3 fs-5'>Список пуст</p> \
                                                </div> \
                                                </div>");

                    $('.empty-list').show(300);
                }

                // Если была удалена последняя история, то вставляем блок "История пуста"
                if ($('.history-table table tr').length <= 1 && $(e.currentTarget).closest('.row').hasClass('history-table')) {
                    
                    $('.header-lists-history').after('<div style="display: none" class="row pt-4 pb-4 empty-history"> \
                                                <div class="col-2 m-auto d-flex text-center flex-column"> \
                                                    <svg class="mt-3" style="display: block; margin: 0 auto" xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-lightbulb-off" viewBox="0 0 16 16"> \
                                                        <path fill-rule="evenodd" d="M2.23 4.35A6.004 6.004 0 0 0 2 6c0 1.691.7 3.22 1.826 4.31.203.196.359.4.453.619l.762 1.769A.5.5 0 0 0 5.5 13a.5.5 0 0 0 0 1 .5.5 0 0 0 0 1l.224.447a1 1 0 0 0 .894.553h2.764a1 1 0 0 0 .894-.553L10.5 15a.5.5 0 0 0 0-1 .5.5 0 0 0 0-1 .5.5 0 0 0 .288-.091L9.878 12H5.83l-.632-1.467a2.954 2.954 0 0 0-.676-.941 4.984 4.984 0 0 1-1.455-4.405l-.837-.836zm1.588-2.653.708.707a5 5 0 0 1 7.07 7.07l.707.707a6 6 0 0 0-8.484-8.484zm-2.172-.051a.5.5 0 0 1 .708 0l12 12a.5.5 0 0 1-.708.708l-12-12a.5.5 0 0 1 0-.708z"/> \
                                                    </svg> \
                                                    <p class="mt-3 fs-5">История пуста</p> \
                                                </div> \
                                            </div>');

                    $('.empty-history').show(300);
                }

            }
            
        },
        error: function() {
            console.log('Server error');
        }
    });
});

// Функция "Выполнено"

$('body').on('click', '#complete-list', (e) => {
    e.preventDefault();

    // Получение данных
	const id = $(e.currentTarget).closest('form').find('input[name="id"]').val();
	const token = $(e.currentTarget).closest('form').find('input[name="_token"]').val();
    const path = window.location.protocol + '//' + window.location.hostname;

    $.ajax({
        url: path + '/todo/complete',
        data: {id: id},
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        success: function(result) {
            
            if (result.proccess == true) {

                $(e.currentTarget).closest('tr').hide(300, () => {
                    $(e.currentTarget).closest('tr').remove();
                })
                
                // Если был выполнен последний список, то добавляем блок "Список пуст"
                if ($('.list-table table tr').length <= 1) {
                    
                    $('.header-lists').after("<div style='display: none' class='row pt-4 pb-4 empty-list'> \
                    <div class='col-2 m-auto d-flex text-center flex-column'> \
                        <svg class='mt-3' style='display: block; margin: 0 auto' xmlns='http://www.w3.org/2000/svg' width='64' height='64' fill='currentColor' viewBox='0 0 16 16'> \
                            <path d='M2.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C3.25 2 2.49 2.759 2.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6zM13.886 7.9v.163c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456V7.332c-1.114 0-1.49-.362-1.49-1.456V4.352C13.51 2.759 12.75 2 11.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6z'></path> \
                        </svg> \
                        <p class='mt-3 fs-5'>Список пуст</p> \
                    </div> \
                    </div>");

                    $('.empty-list').show(300);
                }

                // Если это первый элемент истории, то изначально удаляем блок "История пуста"
                if ($('*').is('.empty-history')) {
                    $('.empty-history').hide(300, () => {
                        $('.empty-history').remove();
                    });

                    // Добавление нового элемента в DOM и плавное появление
                    $('.history-table table tbody').prepend(result.html);
                    $('.just-added').show(300);
                } else {

                    // Добавление нового элемента в DOM и плавное появление
                    $('.history-table table tbody').prepend(result.html);
                    $('.just-added').show(300);

                }

            }
            
        },
        error: function() {
            console.log('Server error');
        }
    });
});

// Обновление списка

$('body').on('click', '#modal-edit', (e) => {
    e.preventDefault();

    // Получение данных
	const id = $(e.currentTarget).closest('form').find('input[name="id"]').val();
	const title = $(e.currentTarget).closest('form').find('input[name="title"]').val();
	const token = $(e.currentTarget).closest('form').find('input[name="_token"]').val();
    const path = window.location.protocol + '//' + window.location.hostname;

    $.ajax({
        url: path + '/todo/update',
        data: {id: id, title: title},
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        success: function(result) {
            
            if (!result.validate) {

                $(e.currentTarget).closest('form').find('.modal-error').html(result.message);

            } else {

                location.reload();

            }
            
        },
        error: function() {
            console.log('Server error');
        }
    });
});

$('.tag-checkbox').click(function (e) {
    $(e.currentTarget).toggleClass('tag-checkbox-active');
});

// Фильтры

$('body').on('change', '#filter-form input', function(e) {
    let checked = $('#filter-form input:checked'),
        tags = '',
        todo_id = $('#filter-form input[name="todo_id"]').val(),
        token = $(e.currentTarget).closest('form').find('input[name="_token"]').val();
        
    checked.each(function () {
        tags += this.value + ',';
    });

    const path = window.location.protocol + '//' + window.location.hostname;
    
    $.ajax({
        url: path + '/tag/filter',
        data: {tags: tags, todo_id: todo_id},
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        beforeSend: function () {
            $('.loader').fadeIn(300, function () {
                $('.list-table table tbody').hide(300);
                $('.list-table table tbody').remove();
            });
        },
        success: function(result) {

            console.log(result);

            $('.loader').fadeOut(300, function () {
                $('.list-table table thead').after(result).show(300);
            });
        },
        error: function() {
            console.log('Server error');
        }
    });

});