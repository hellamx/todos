<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Регистрация пользователя
     *
     * @param  Request  $request
     * @return mixed Возвращает JSON response
    */
    public function store(Request $request)
    {
        /**
         * Выборка только нужных данных
         */
        $data = $request->only(['name', 'password']);

        /**
         * Правила валидации
         */
        $rules = [
            'name' => 'required|min:4|max:25|unique:users',
            'password' => 'required|min:6'
        ];

        /**
         * Кастомный перевод для ошибок
         */
        $messages = [
            'name.required' => 'Имя обязательно к заполнению',
            'name.min' => 'Поле имени должно содержать не менее 4 символов',
            'name.max' => 'Поле имени должно содержать не более 25 символов',
            'name.unique' => 'Такое имя уже занято',
            'password.required' => 'Пароль обязателен к заполнению',
            'password.min' => 'Поле пароля должно содержать не менее 6 символов'
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules, $messages);
        
        /**
         * Проверка на наличие ошибок
         * Если есть ошибки, то в JS вернется json с сообщением и false
         */
        if ($validator->fails()) {
            return response()->json([
                'validate' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        /**
         * Сохранение пользователя в базу
         */
        $user = User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password'])
        ]);

        /**
         * Аутентификация пользователя сразу после регистрации
         */
        if(Auth::login($user)) {
        
            return response()->json([
                'validate' => true,
            ]);
        
        }

    }

    /**
     * Аутентификация пользователя
     * @param  \Illuminate\Http\Request $request
     */
    public function login(Request $request)
    {
        /**
         * Выборка только нужных данных
         */
        $data = $request->only(['name', 'password']);
        
        /**
         * Правила валидации
         */
        $rules = [
            'name' => 'required|min:4|max:25',
            'password' => 'required|min:6'
        ];

        /**
         * Кастомный перевод для ошибок
         */
        $messages = [
            'name.required' => 'Имя обязательно к заполнению',
            'name.min' => 'Поле имени должно содержать не менее 4 символов',
            'name.max' => 'Поле имени должно содержать не более 25 символов',
            'password.required' => 'Пароль обязателен к заполнению',
            'password.min' => 'Поле пароля должно содержать не менее 6 символов'
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules, $messages);

        /**
         * Проверка на наличие ошибок
         * Если есть ошибки, то в JS вернется json с сообщением и false
         */
        if ($validator->fails()) {
            return response()->json([
                'validate' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        /**
         * Аутентификация
         * Если HTTP вернет json с ключом true, то JS мгновенно делает редирект на главную страницу
         */
        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            return response()->json([
                'validate' => true,
            ]);
        } else {
            return response()->json([
                'validate' => false,
                'message' => 'Неверный логин или пароль'
            ]);
        }
    }

    /**
     * Выход пользователя из аккаунта
     * @param  \Illuminate\Http\Request $request
     */
    public function logout(Request $request)
    {
        Auth::logout();
    
        /**
         * Аннулируем сеанс
         */
        $request->session()->invalidate();
 
        /**
         * Генерируем новый CSRF токен
         */
        $request->session()->regenerateToken();

        /**
         * Редирект на главную страницу
         */
        return redirect()->route('dashboard');
    }
}
