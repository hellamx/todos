<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    /*
     * Разрешенные к заполнению поля
     */
    protected $fillable = [
        'name',
        'password'
    ];

    /*
     * Отношение один ко многим
     */
    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
}
