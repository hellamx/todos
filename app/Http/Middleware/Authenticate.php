<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Отдаем ошибку 404, если гость пытается получить доступ пользовательской части
     */
    protected function redirectTo(Request $request): ?string
    {
        return abort(404);
    }
}
