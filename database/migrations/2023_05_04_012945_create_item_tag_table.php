<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Создание связующей теги и пункты списка таблицы
     */
    public function up(): void
    {
        Schema::create('item_tag', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->integer('tag_id');
        });
    }

    /**
     * Удаление таблицы
     */
    public function down(): void
    {
        Schema::dropIfExists('item_tag');
    }
};
