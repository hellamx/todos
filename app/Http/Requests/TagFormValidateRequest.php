<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TagFormValidateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Валидационные правила
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3'
        ];
    }

    /**
     * Сообщения для ошибок
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Заголовок тега обязателен к заполнению',
            'title.min' => 'Поле заголовка тега должно содержать не менее 3 символов',
        ];
    }
}
