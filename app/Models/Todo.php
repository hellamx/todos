<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Todo extends Model
{
    use HasFactory;
    
    /*
     * Трейт библиотеки sluggable
     */
    use HasSlug;
    
    /*
     * Разрешенные к заполнению поля
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug'
    ];

    /*
     * Настройки генерации slug
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /*
     * Отношение многие к одному
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Отношение один ко многим
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /*
     * Отношение многие ко многим
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
