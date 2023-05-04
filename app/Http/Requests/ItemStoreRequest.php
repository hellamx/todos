<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ItemStoreRequest extends FormRequest
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
            'title' => 'required|min:5'
        ];
    }

    /**
     * Сообщения для ошибок
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Заголовок обязателен к заполнению',
            'title.min' => 'Поле заголовка должно содержать не менее 5 символов',
        ];
    }
}
