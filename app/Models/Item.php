<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /*
     * Разрешенные к заполнению поля
     */
    protected $fillable = [
        'todo_id',
        'title'
    ]; 

    /*
     * Отношение многие к одному
     */
    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }

    /*
     * Отношение многие ко многим
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
