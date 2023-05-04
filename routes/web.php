<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers as C;

/**
 * Главная страница
 */
Route::get('/', [C\MainController::class, 'index'])->name('dashboard');

/*
 * Роуты для работы с регистрацией и аутентификацией
 * Добавляем к названию каждого роута user.
 * Привязываем к middleware - только для гостей
 */
Route::name('user.')->middleware('guest')->group(function () {
    Route::post('/user/signup', [C\UserController::class, 'store'])->name('store');
    Route::post('/user/login', [C\UserController::class, 'login'])->name('login');
});

Route::get('/user/logout', [C\UserController::class, 'logout'])->name('user.logout')->middleware('auth');

/*
 * Роуты для работы со списками
 * Добавляем к названию каждого роута todo.
 * Привязываем к middleware - только для аутентифицированных пользователей
 */
Route::name('todo.')->middleware('auth')->group(function () {
    Route::get('/todo/{slug}', [C\TodoController::class, 'page'])->name('page');
    Route::post('/todo/create', [C\TodoController::class, 'store'])->name('store');
    Route::post('/todo/complete', [C\TodoController::class, 'complete'])->name('complete');
    Route::delete('/todo/delete', [C\TodoController::class, 'destroy'])->name('destroy');
    Route::post('/todo/update', [C\TodoController::class, 'update'])->name('update');
});

/*
 * Роуты для работы с пунктами списка и изображениями
 * Привязываем к middleware - только для аутентифицированных пользователей
 */
Route::middleware('auth')->group(function () {
    Route::post('/{slug}/create', [C\ItemController::class, 'store'])->name('item.store');
    Route::delete('/item/destroy', [C\ItemController::class, 'destroy'])->name('item.destroy');
    Route::get('/item/search', [C\ItemController::class, 'search'])->name('item.search');
    Route::post('/{item_id}/image-upload', [C\ItemController::class, 'upload'])->name('image.upload');
    Route::delete('/image-delete', [C\ItemController::class, 'imageDestroy'])->name('image.destroy');
});

/*
 * Роуты для работы с тегами
 * Добавляем к названию каждого роута tag.
 * Привязываем к middleware - только для аутентифицированных пользователей
 */
Route::name('tag.')->middleware('auth')->group(function () {
    Route::post('/tag/add', [C\TagController::class, 'store'])->name('store');
    Route::delete('/tag/delete', [C\TagController::class, 'destroy'])->name('destroy');
    Route::post('/tag/attach', [C\TagController::class, 'attach'])->name('attach');
    Route::post('/tag/filter', [C\TagController::class, 'filter'])->name('filter');
});