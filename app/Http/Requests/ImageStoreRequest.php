<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ImageStoreRequest extends FormRequest
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
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:1024'
        ];
    }

    /**
     * Сообщения для ошибок
     */
    public function messages(): array
    {
        return [
            'image.required' => 'Вы не прикрепили изображение',
            'image.image' => 'Формат не поддерживается',
            'image.mimes' => 'Формат не поддерживается',
            'image.max' => 'Превышен объем загружаемого изображения'
        ];
    }
}
