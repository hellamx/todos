<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TagFormValidateRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\Todo;
use App\Models\Tag;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{

    /**
     * Сохранение пункта списка с помощью AJAX
     * @param TagFormValidateRequest $request
    */
    public function store(TagFormValidateRequest $request)
    {
        $validated = $request->validated();
        $todo = Todo::find($request->todo_id);
        if (Auth::user()->id != $todo->user_id) abort(404);

        /**
         * Сохранение тега в базу данных
         */
        Tag::create([
            'title' => $validated['title'],
            'todo_id' => $todo->id
        ]);

        session()->flash('success', 'Тег успешно добавлен');
        return redirect()->back();
    }

    /**
     * Удаление тега
     * @param Request $request
    */
    public function destroy(Request $request)
    {
        /**
         * Проверка на принадлежность тега к пользователю
         */
        if (Auth::user()->id != Tag::find($request->tag_id)->todo->user_id) abort(404);

        /**
         * Удаление тега
         */
        Tag::destroy([$request->tag_id]);
        
        /**
         * Сохранение уведомления и редирект
         */
        session()->flash('success', 'Тег успешно удален');
        return redirect()->back();
    }

    /**
     * Прикрепление тега к пункту списка
     * @param Request $request
    */
    public function attach(Request $request)
    {
        /**
         * Проверка на принадлежность тега и списка к пользователю
         */
        if (Auth::user()->id != Tag::find($request->tag)->todo->user_id) abort(404);

        /**
         * Прикрепление тега к пункту
         */
        $item = $request->item_id;
        $tag = $request->tag;

        Tag::find($tag)->items()->sync($item, false);

        session()->flash('success', 'Тег успешно прикреплен');
        return redirect()->back();
    }

    /**
     * Фильтрация по тегам
     * @param Request $request
    */
    public function filter(Request $request)
    {

        if ($request->filled('tags')) {
            $tags = $request->tags;
            $tags = explode(',', $tags, -1);

            $items = Item::with('tags')->orderBy('id', 'desc')->whereHas('tags', function($q) use ($tags) {
                $q->whereIn('tag_id', $tags);
            })->get();
            
            return view('layouts.filters', [
                'items' => $items,
                'tags' => Todo::find($request->todo_id)->tags,
            ])->render();
        } else {
            $items = Item::select('*')->where('todo_id', '=', $request->todo_id)->orderBy('id', 'desc')->with('tags')->get();

            return view('layouts.filters', [
                'items' => $items,
                'tags' => Todo::find($request->todo_id)->tags,

            ])->render();
        }
    }
}
