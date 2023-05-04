<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageStoreRequest;
use App\Http\Requests\ItemStoreRequest;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

use App\Models\Item;
use App\Models\Todo;

class ItemController extends Controller
{

    /**
     * Сохранение пункта списка с помощью AJAX
     * @param ItemStoreRequest $request
    */
    public function store(ItemStoreRequest $request, $slug)
    {

        /**
         * Валидация и получение данных
         */
        $data = $request->validated();
        
        /**
         * Сохранение пункта в базу данных
         */
        if ($todo = Todo::select('id')->where('slug', '=', $slug)->get()[0]) {

            Item::create([
                'title' => $data['title'],
                'todo_id' => $todo->id
            ]);

            session()->flash('success', 'Пункт успешно добавлен');
            return redirect()->back();
        } 

    }

    /**
     * Удаление пункта списка
     *
     * @param  Request  $request
     * @return void
    */
    public function destroy(Request $request)
    {
        $data = $request->only(['id']);

        /**
         * Проверка на существование такого пункта
         */
        $item = Item::find($data['id']);
        if (!$item) abort(404);

        /**
         * Проверка на принадлежность спикса к пользователю
         */
        if($item->todo->user_id != Auth::user()->id) abort(404);
        
        /**
         * Удаление пункта меню
         */
        Item::destroy([$data['id']]);
        
        /**
         * Сохранение уведомления и редирект
         */
        session()->flash('success', 'Пункт успешно удален');
        return redirect()->back();
    }

    /**
     * Загрузка картинки
     *
     * @param  ImageStoreRequest $request
    */
    public function upload(ImageStoreRequest $request, $item_id)
    {

        /**
         * Проверка на принадлежность спикса к пользователю
         */
        $item = Item::find($item_id);
        if($item->todo->user_id != Auth::user()->id) abort(404);

        /**
         * Валидация и получение данных
         */
        $validated = $request->validated();

        /**
         * Название превью изображения: user_id + метка времени + приставка _preview + расширение
         */
        $previewName = Auth::user()->id . time(). '_preview' . '.'.$validated['image']->extension();

        /**
         * Название исходного изображения: user_id + метка времени + приставка _full + расширение
         */
        $imageName = Auth::user()->id . time(). '_full' . '.'.$validated['image']->extension();

        /**
         * Сохранение в публичную папку
         */
        $validated['image']->move(public_path('images'), $imageName);

        /**
         * Обрезание изображения
         */
        $preview = Image::make(public_path('images') . '\\' . $imageName);
        $preview->resize(150, 150, function($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('images') . '\\' . $previewName);
        
        /**
         * Удаление существующих файлов, если таковые существуют
         */
        if ($item->img_preview || $item->img_full) {
            unlink(public_path('images') . '\\' . $item->img_preview);
            unlink(public_path('images') . '\\' . $item->img_full);
        }
    
        /**
         * Обновление данных в базе данных
         */
        $item->img_preview = $previewName;
        $item->img_full = $imageName;
        
        if($item->save()) {
            session()->flash('success', 'Изображение успешно загружено');
            return redirect()->back();
        } else {
            abort(404);
        }
        
    }

    /**
     * Удаление картинки
     * @param  Request  $request
    */
    public function imageDestroy(Request $request)
    {
        /**
         * Проверка на принадлежность спикса к пользователю
         */
        $item = Item::find($request->id);
        if($item->todo->user_id != Auth::user()->id) abort(404);

        /**
         * Удаление файлов
         */
        unlink(public_path('images') . '\\' . $item->img_preview);
        unlink(public_path('images') . '\\' . $item->img_full);

        /**
         * Обновление базы данных
         */
        $item->img_full = null;
        $item->img_preview = null;

        if($item->save()) {
            session()->flash('success', 'Изображение успешно удалено');
            return redirect()->back();
        } else {
            abort(404);
        }

    }

    /**
     * Поиск
     * @param Request $request
    */
    public function search(Request $request)
    {

        /**
         * Проверка на принадлежность спикса к пользователю
         */
        $todo = Todo::find($request->todo_id);
        if($todo->user_id != Auth::user()->id) abort(404);

        /**
         * Если запрос идет через Ajax, то отдаем json ответ
         */
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            
            $items = Item::select('title')->where('todo_id', '=', $request->todo_id)->where('title', 'LIKE', '%' . $request->s . '%')->get();
            return json_encode($items);
            
        } else {

            /**
             * Проверка на передачу get параметра s и todo_id
             */
            if($request->filled('s') && $request->filled('todo_id')) {
                
                /**
                 * Получение результатов
                 */
                $items = Item::select('*')->where('todo_id', '=', $request->todo_id)->where('title', 'LIKE', '%' . $request->s . '%')->get();
                
                /**
                 * Подключение вида и передача результатов
                 */
                return view('search', ['items' => $items, 'query' => $request->s]);

            } else {
                return view('search', ['items' => collect(), 'query' => 'запрос пуст']);
            }

        }
    }

}
