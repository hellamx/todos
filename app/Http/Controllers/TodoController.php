<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Сохранение списка с помощью AJAX
     *
     * @param  Request  $request
     * @return mixed Возвращает JSON response
    */
    public function store(Request $request)
    {
        /**
         * Выборка только нужных данных
         */
        $data = $request->only(['title']);
        
        /**
         * Правила валидации
         */
        $rules = [
            'title' => 'required|min:5'
        ];

        /**
         * Кастомный перевод для ошибок
         */
        $messages = [
            'title.required' => 'Заголовок обязателен к заполнению',
            'title.min' => 'Поле заголовка должно содержать не менее 5 символов',
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
         * Сохранение списка в базу данных
         */
        $todo = Todo::create([
            'title' => $data['title'],
            'user_id' => Auth::user()->id
        ]);

        /**
         * Передаем в JS html для отображения только что добавленного списка
         */
        return response()->json([
            'html' => view('layouts.added-list', ['todo' => $todo])->render()
        ]);
        
    }

    /**
     * Отображение списка
     *
     * @param  $slug
    */
    public function page($slug)
    {

        /**
         * Проверка на существование записи
         */
        if(!Todo::where('slug', '=', $slug)->exists()) {
            abort(404);
        }

        $todo = (Todo::select('*')->where('slug', '=', $slug)->get()[0]);

        /**
         * Проверка принадлежность списка к пользователю
         */
        if (Auth::user()->id != $todo->user_id) abort(404);

        /**
         * Проверка на статус списка, если = 1, то он неактивен
         */
        if ($todo->status == 1) abort(404);

        return view('todo', [
            'todo' => $todo,
            'items' => $todo->items()->with('tags')->where('todo_id', '=', $todo->id)->orderBy('id', 'desc')->get(),
            'tags' => $todo->tags
        ]);
    }

    /**
     * Сохранение списка с помощью AJAX
     *
     * @param  Request  $request
    */
    public function destroy(Request $request)
    {
        $todo = Todo::find($request->id);

        if (Auth::user()->id != $todo->user_id) abort(404);
        
        /**
         * Удаление загруженных файлов, если таковые существуют
         */
        if ($todo->items->first()) {
            
            if ($todo->items->first()->img_preview) unlink(public_path('images') . '\\' . $todo->items->first()->img_preview);
            if ($todo->items->first()->img_full) unlink(public_path('images') . '\\' . $todo->items->first()->img_full);
        }

        if (Todo::destroy([$todo->id])) {
            return response()->json([
                'proccess' => true
            ]);
        } else {
            return response()->json([
                'proccess' => false
            ]);
        }

    }

    /**
     * Изменение статуса `status` = 1
     *
     * @param  Request  $request
    */
    public function complete(Request $request)
    {
        $todo = Todo::find($request->id);

        if (Auth::user()->id != $todo->user_id) abort(404);
        
        $todo->status = 1;

        /**
         * Передаем в JS html для отображения только что выполненного списка
         */
        if($todo->save()) {
            return response()->json([
                'proccess' => true,
                'html' => view('layouts.added-history', ['todo' => $todo])->render()
            ]);
        } else {
            return response()->json([
                'proccess' => false
            ]);
        }
    }

    /**
     * Обновление списка
     *
     * @param  Request  $request
    */
    public function update(Request $request)
    {
        $todo = Todo::find($request->id);

        if (Auth::user()->id != $todo->user_id) abort(404);

        /**
         * Правила валидации
         */
        $rules = [
            'title' => 'required|min:5'
        ];

        /**
         * Кастомный перевод для ошибок
         */
        $messages = [
            'title.required' => 'Заголовок обязателен к заполнению',
            'title.min' => 'Поле заголовка должно содержать не менее 5 символов',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages);
        
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
        
        $todo->title = $request->title;

        if($todo->save()) {
            return response()->json([
                'validate' => true,
            ]);
        }

    }
}
