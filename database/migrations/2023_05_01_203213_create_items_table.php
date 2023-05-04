<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Создание таблицы пунктов списка
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('todo_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('img_preview')->nullable();
            $table->string('img_full')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Удаление таблицы пунктов списка
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
